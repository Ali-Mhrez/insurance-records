<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentAndRemittanceBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_and_remittance_books', function (Blueprint $table) {
            $table->id();
            $table->enum('issued_by', ['صادر عن القسم', 'وارد من البنك']);
            $table->string('title');
            $table->date('date');
            $table->integer('payment_id')->unsigned();
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
        Schema::dropIfExists('payment_and_remittance_books');
    }
}
