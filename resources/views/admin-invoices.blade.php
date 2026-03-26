@extends('admin')

@section('content')

<div class="invoice-container">

    <!-- Header -->
    <div class="invoice-header">
        <div>
            <h2>Invoices</h2>
            <p>Manage and track your client invoices</p>
        </div>

        <button class="btn-create">+ Create Invoice</button>
    </div>

    <!-- Summary Cards -->
    <div class="cards">

        <div class="card">
            <p>Total Invoiced</p>
            <h3>${{ number_format($totalAmount, 2) }}</h3>
            <span>{{ $totalCount }} invoices total</span>
        </div>

        <div class="card green">
            <p>Paid</p>
            <h3>${{ number_format($paidAmount, 2) }}</h3>
            <span>{{ $paidCount }} invoices paid</span>
        </div>

        <div class="card red">
            <p>Overdue</p>
            <h3>${{ number_format($overdueAmount, 2) }}</h3>
            <span>{{ $overdueCount }} overdue invoice{{ $overdueCount > 1 ? 's' : '' }}</span>
        </div>

    </div>

    <!-- Filters -->
    <div class="filters">
        <a href="{{ route('admin.invoices', ['status' => 'all']) }}">
            <button class="{{ request('status', 'all') == 'all' ? 'active' : '' }}">All</button>
        </a>

        <a href="{{ route('admin.invoices', ['status' => 'paid']) }}">
            <button class="{{ request('status') == 'paid' ? 'active' : '' }}">Paid</button>
        </a>

        <a href="{{ route('admin.invoices', ['status' => 'unpaid']) }}">
            <button class="{{ request('status') == 'unpaid' ? 'active' : '' }}">Unpaid</button>
        </a>

        <a href="{{ route('admin.invoices', ['status' => 'overdue']) }}">
            <button class="{{ request('status') == 'overdue' ? 'active' : '' }}">Overdue</button>
        </a>
    </div>

    <!-- Table -->
    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Client</th>
                    <th>Project</th>
                    <th>Amount</th>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td class="invoice-id">INV-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $invoice->client->company_name ?? 'N/A' }}</td>
                    <td>{{ $invoice->project->project_name ?? 'N/A' }}</td>
                    <td>${{ number_format($invoice->amount, 2) }}</td>
                    <td>{{ date('M d, Y', strtotime($invoice->invoice_date)) }}</td>
                    <td class="{{ $invoice->payment_status == 'overdue' ? 'text-red' : '' }}">
                        {{ date('M d, Y', strtotime($invoice->due_date)) }}
                    </td>
                    <td>
                        <span class="status {{ $invoice->payment_status }}">
                            {{ ucfirst($invoice->payment_status) }}
                        </span>
                    </td>

                    <!-- ACTIONS -->
                    <td>
                        <button type="button" class="invoice-view-btn action"
                            data-id="{{ $invoice->id }}"
                            data-client="{{ $invoice->client->company_name ?? 'N/A' }}"
                            data-project="{{ $invoice->project->project_name ?? 'N/A' }}"
                            data-amount="{{ $invoice->amount }}"
                            data-date="{{ date('F d, Y', strtotime($invoice->invoice_date)) }}"
                            data-due="{{ date('F d, Y', strtotime($invoice->due_date)) }}"
                            data-status="{{ ucfirst($invoice->payment_status) }}"
                            data-payments='@json($invoice->payments)'>
                            <i class="fa fa-eye"></i>
                        </button>

                        <a href="{{ route('admin.invoices.download', $invoice->id) }}">
                            <i class="fa fa-download action"></i>
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<div id="invoiceModalUnique" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999;">
    
    <div style="background:#fff; width:500px; margin:80px auto; padding:20px; border-radius:10px; position:relative;">
        
        <span id="closeModalBtn" style="position:absolute; right:15px; top:10px; cursor:pointer; font-size:20px;">&times;</span>
        
        <h3>Invoice Details</h3>
        <div id="invoiceModalBodyUnique"></div>

    </div>
</div>
</div>

</div>

@endsection

<!-- 🔥 UNIQUE CSS -->
<style>
.invoice-modal-unique {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
}

.invoice-modal-content-unique {
    background: #fff;
    width: 600px;
    margin: 5% auto;
    padding: 20px;
    border-radius: 12px;
}

.invoice-modal-header-unique {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #ddd;
    margin-bottom: 10px;
}

.invoice-close-unique {
    font-size: 22px;
    cursor: pointer;
}

.receipt-wrapper {
    font-family: monospace;
    font-size: 13px;
    color: #222;
}

.receipt-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
}

.receipt-table-clean {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
    margin-bottom: 10px;
}

.receipt-table-clean th {
    text-align: left;
    border-bottom: 2px solid #333;
    padding: 6px;
    font-weight: bold;
}

.receipt-table-clean td {
    padding: 6px;
    border-bottom: 1px solid #ccc;
}

.receipt-summary {
    border-top: 2px solid #333;
    margin-top: 10px;
    padding-top: 10px;
}

.receipt-summary .receipt-row {
    font-weight: 500;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const buttons = document.querySelectorAll(".invoice-view-btn");
    const modal = document.getElementById("invoiceModalUnique");
    const content = document.getElementById("invoiceModalBodyUnique");
    const closeBtn = document.getElementById("closeModalBtn");

    buttons.forEach(btn => {
        btn.addEventListener("click", function () {

            let amount = parseFloat(this.dataset.amount);

            // GET PAYMENTS ARRAY
            let payments = JSON.parse(this.dataset.payments || "[]");

            // CALCULATE TOTAL PAID
            let totalPaid = payments.reduce((sum, p) => sum + parseFloat(p.amount), 0);

            let balance = amount - totalPaid;

            // BUILD PAYMENTS TABLE
            let paymentsHTML = '';

            if (payments.length > 0) {
                payments.forEach(p => {
                    paymentsHTML += `
                        <tr>
                            <td>${p.id}</td>
                            <td>${p.payment_date}</td>
                            <td>$${parseFloat(p.amount).toFixed(2)}</td>
                            <td>${p.method}</td>
                        </tr>
                    `;
                });
            } else {
                paymentsHTML = `<tr><td colspan="4">No payments yet</td></tr>`;
            }

            let html = `
            <div class="receipt-wrapper">

                <div class="receipt-row">
                    <span>Invoice ID</span>
                    <span>INV-${this.dataset.id.padStart(4,'0')}</span>
                </div>

                <div class="receipt-row">
                    <span>Issue Date</span>
                    <span>${this.dataset.date}</span>
                </div>

                <div class="receipt-row">
                    <span>Due Date</span>
                    <span>${this.dataset.due}</span>
                </div>

                <div class="receipt-row">
                    <span>Client</span>
                    <span>${this.dataset.client}</span>
                </div>

                <div class="receipt-row">
                    <span>Project</span>
                    <span>${this.dataset.project}</span>
                </div>

                <!-- ITEMS TABLE -->
                <table class="receipt-table-clean">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Line Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${this.dataset.project}</td>
                            <td>1</td>
                            <td>${parseFloat(this.dataset.amount).toLocaleString()}</td>
                            <td>${parseFloat(this.dataset.amount).toLocaleString()}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- TOTALS -->
                <div class="receipt-summary">
                    <div class="receipt-row">
                        <span>Subtotal</span>
                        <span>${parseFloat(this.dataset.amount).toLocaleString()}</span>
                    </div>

                    <div class="receipt-row">
                        <span>Total Paid</span>
                        <span>${totalPaid.toLocaleString()}</span>
                    </div>

                    <div class="receipt-row">
                        <span>Balance Due</span>
                        <span>${balance.toLocaleString()}</span>
                    </div>

                    <div class="receipt-row">
                        <span>Payment Status</span>
                        <span>${this.dataset.status}</span>
                    </div>
                </div>

                <!-- PAYMENTS -->
                <table class="receipt-table-clean">
                    <thead>
                        <tr>
                            <th>Payments</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${paymentsHTML}
                    </tbody>
                </table>

            </div>
            `;

            content.innerHTML = html;
            modal.style.display = "block";
        });
    });

    closeBtn.onclick = () => modal.style.display = "none";

    window.onclick = function(e) {
        if (e.target === modal) modal.style.display = "none";
    };

});
</script>