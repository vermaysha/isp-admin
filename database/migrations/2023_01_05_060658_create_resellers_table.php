<?php

use App\Enums\ResellerType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('resellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('Owner')->constrained();
            $table->string('name')->nullable()->comment('Company Name');
            $table->string('photo')->nullable();
            $table->string('email')->nullable()->comment('Company Email');
            $table->string('phone_number')->nullable()->comment('Company Phone Number');
            $table->foreignId('address_id')->constrained()->nullable()->comment('Company Address');
            $table->string('npwp')->nullable()->comment('NPWP Number');
            $table->string('pks')->nullable()->comment('PKS number');
            $table->string('contract_file')->nullable()->comment('Contract File');
            $table->unsignedTinyInteger('type')->default(ResellerType::INDIRECT->value);
            $table->date('contract_start_at')->nullable();
            $table->date('contract_end_at')->nullable();
            $table->date('inactive_at')->nullable();
            $table->softDeletesTz();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resellers');
    }
};
