<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFpaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fpayments', function (Blueprint $table) {
            $table->id();
            $table->string('bidder_name');
            $table->integer('value');
            $table->enum('currency',config('currency.CURRENCY'));
            $table->integer('equ_val_sy')->nullable();
            $table->string('matter');
            $table->string('contract_number');
            $table->date('contract_date');
            $table->string('number')->unique();
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
        Schema::dropIfExists('fpayments');
    }
}
