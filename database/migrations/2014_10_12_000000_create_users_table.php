<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ibm')->unique();
            $table->string('level')->default('1');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban_number')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('identification_number')->nullable();
            $table->string('provider_policy_number')->nullable();
            $table->bigInteger('premium_amount')->nullable();
            $table->string('refer_ibm')->nullable();
            $table->string('passed_up_to')->nullable();
            $table->boolean('is_root')->default('0');
            $table->string('gender')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
