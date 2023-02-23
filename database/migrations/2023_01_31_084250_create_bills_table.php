<?php

use App\Models\Plan;
use Bavix\Wallet\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->unique();
            $table->unsignedInteger('type')->default(1);
            $table->decimal('amount', 64, 2)->comment('Balance Without any tax');
            $table->decimal('tax', 64, 2)->comment('PPN');
            $table->decimal('grand_total', 62, 2)->comment('Balance With PPN & BHP USO');
            $table->foreignId('transaction_id')->nullable()->constrained((new Transaction())->getTable());
            $table->string('bill_photo')->nullable();
            $table->string('invoice_file')->nullable();
            $table->foreignId('reseller_id')->nullable()->constrained();
            $table->string('reseller_name');
            $table->foreignId('client_id')->nullable()->constrained();
            $table->string('client_name');
            $table->foreignId('plan_id')->nullable()->constrained();
            $table->string('plan_name');
            $table->decimal('plan_price', 62, 2);
            $table->bigInteger('plan_bandwidth');
            $table->set('plan_tax_type', [
                Plan::TAX_EXCLUDED,
                Plan::TAX_INCLUDED,
            ])->default(Plan::TAX_INCLUDED);
            $table->text('description')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('payed_at')->nullable();
            $table->date('payment_month')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
};
