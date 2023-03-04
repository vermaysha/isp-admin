<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('fullname')->nullable();
            $table->string('photo')->nullable();
            $table->text('address')->nullable();
            $table->string('nik')->nullable();
            $table->string('ktp_file')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('birth')->nullable();
            $table->set('gender', ['male', 'female', 'other'])->nullable();
            $table->rememberToken()->nullable();
            $table->softDeletesTz();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
