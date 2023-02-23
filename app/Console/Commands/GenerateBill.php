<?php

namespace App\Console\Commands;

use App\Jobs\GenerateInvoice;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Plan;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Log;
use Throwable;

class GenerateBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bill:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate bill for previous month for all client';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $clients = Client::with([
            'user',
            'plan',
            'reseller',
            'lastBill',
        ])->orderBy('id', 'desc')->get();

        $bills = [];

        foreach ($clients as $client) {
            $now = now()->setMonth(1)->setDay(1);
            $createdAt = CarbonImmutable::parse($client->lastBill->payment_month);
            $diffMonth = CarbonImmutable::parse($createdAt->format('Y-m'))
                ->setTime($now->hour, $now->minute, $now->second)
                ->diffInMonths($now);

            // Skip creating bill when user had bill
            if (empty($diffMonth)) {
                continue;
            }

            $now = $createdAt->addMonths(2);

            $invoiceId = sprintf(
                'INV/%s/%03d/%s',
                $now->format('Ymd'),
                $client->id,
                random_number(4)
            );

            if ($client->plan->tax_type === Plan::TAX_INCLUDED) {
                $tax = $client->plan->price * Bill::TAX;
                $price = $client->plan->price - $tax;
            } else {
                $tax = $client->plan->price * Bill::TAX;
                $price = $client->plan->price;
            }

            $grandTotal = $price + $tax;

            array_push($bills, [
                'invoice_id' => $invoiceId,
                'type' => Bill::TYPE_EXTENSION,
                'amount' => $price,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'reseller_id' => $client->reseller->id,
                'reseller_name' => $client->reseller->name,
                'client_id' => $client->id,
                'client_name' => $client->user->fullname,
                'plan_id' => $client->plan_id,
                'plan_name' => $client->plan->name,
                'plan_price' => $client->plan->price,
                'plan_tax_type' => $client->plan->tax_type,
                'plan_bandwidth' => $client->plan->bandwidth,
                'description' => sprintf(
                    'Perpanjangan paket %s',
                    $client->plan->name
                ),
                'created_at' => $now,
                'payment_month' => $now->setDay(1)->subMonth(),
                'updated_at' => $now,
            ]);
        }

        try {
            DB::transaction(function () use ($bills) {
                Bill::insert($bills);
            }, 5);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return Command::FAILURE;
        }

        foreach (Bill::with(['client', 'client.user', 'reseller'])->whereNull('invoice_file')->get() as $bill) {
            GenerateInvoice::dispatch($bill);
        }

        return Command::SUCCESS;
    }
}
