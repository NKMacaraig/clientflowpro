<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'project_id',
        'amount',
        'invoice_date',
        'due_date',
        'payment_status'
    ];

    // An Invoice belongs to a Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // An Invoice belongs to a Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Optional: Payments for this invoice (if you add a Payment model)
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function downloadInvoice(Invoice $invoice)
    {
        $invoice->load(['client', 'project', 'payments']);

        $pdf = Pdf::loadView('admin-invoice-pdf', compact('invoice'));

        return $pdf->download('Invoice-' . $invoice->id . '.pdf');
    }
}