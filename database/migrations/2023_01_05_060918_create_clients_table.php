<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('plan_id')->constrained();
            $table->foreignId('reseller_id')->constrained();
            $table->decimal('plan_price', 64, 2)->nullable()->comment('Custom plan price');
            $table->string('plan_bandwidth')->nullable()->comment('Custom plan bandwidth');
            $table->string('npwp')->nullable();
            $table->string('payment_due_date')->default(10)->nullable();
            $table->boolean('is_ppn')->default(false);
            $table->unsignedBigInteger('status')->default(0);
            $table->timestamp('installed_at')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->timestamp('inactive_at')->nullable();
            $table->softDeletesTz();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
