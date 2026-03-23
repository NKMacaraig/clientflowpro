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

    <!-- Total -->
    <div class="card">
        <p>Total Invoiced</p>
        <h3>${{ number_format($totalAmount, 2) }}</h3>
        <span>{{ $totalCount }} invoices total</span>
    </div>

    <!-- Paid -->
    <div class="card green">
        <p>Paid</p>
        <h3>${{ number_format($paidAmount, 2) }}</h3>
        <span>{{ $paidCount }} invoices paid</span>
    </div>

    <!-- Overdue -->
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
                    <td>{{ $invoice->client->name ?? 'N/A' }}</td>
                    <td>{{ $invoice->project->name ?? 'N/A' }}</td>
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
                    <td>
                        <i class="fa fa-eye action"></i>
                        <i class="fa fa-download action"></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection