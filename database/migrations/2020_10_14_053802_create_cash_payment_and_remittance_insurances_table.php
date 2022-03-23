<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashPaymentAndRemittanceInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_payment_and_remittance_insurances', function (Blueprint $table) {
            $table->id();
            $table->string('bidder_name');
            $table->integer('value');
            $table->enum('currency', config('currency.CURRENCY'));
            $table->integer('equ_val_sy')->nullable();
            $table->string('matter');
            $table->string('number');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onUpdate('cascade');
            $table->date('date');
            $table->enum('status', ['مدخلة', 'محررة', 'مصادرة']);
            $table->enum('type', ['دفعة نقدية', 'حوالة']);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('cash_payment_and_remittance_insurances');
    }
}
