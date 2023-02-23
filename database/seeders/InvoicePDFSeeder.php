<?php

namespace Database\Seeders;

use App\Jobs\GenerateInvoice;
use App\Models\Bill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class InvoicePDFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Process::run(sprintf(
            'rm -rf %s',
            Storage::disk('invoices')->path('')
        ));

        foreach (Bill::with(['client', 'client.user', 'reseller'])->whereNull('invoice_file')->get() as $bill) {
            GenerateInvoice::dispatch($bill);
        }
    }
}
