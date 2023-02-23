<?php

namespace App\Jobs;

use App\Models\Bill;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class GenerateInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Bill $bill
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $pdf = Pdf::loadView('pdf.invoice', [
            'bill' => $this->bill,
        ]);

        // Generate Client id with zero prefix
        $clientId = sprintf(
            '%03d',
            $this->bill->client_id
        );

        // Generate Invoice Filename
        $filename = sprintf(
            '%s/%s.pdf',
            $clientId,
            Str::slug($this->bill->invoice_id)
        );

        $pdf->save($filename, 'invoices');

        // Save Invoice FilePath to Table
        $this->bill->invoice_file = $filename;
        $this->bill->save();
    }
}
