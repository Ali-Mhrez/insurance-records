<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFchecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fchecks', function (Blueprint $table) {
            $table->id();
            $table->string('bidder_name');
            $table->enum('currency', config('currency.CURRENCY'));
            $table->integer('value');
            $table->integer('equ_val_sy')->nullable();
            $table->string('matter');
            $table->string('contract_number');
            $table->date('contract_date');
            $table->string('number')->unique();
            $table->date('date');
            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks')->onUpdate('cascade');
            $table->date('merit_date');
            $table->enum('status',['مدخل','محرر','مصادر','مجدد']);
            $table->integer('renewd_check_id')->unsigned()->nullable();
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
        Schema::dropIfExists('fchecks');
    }
}
