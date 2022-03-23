<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuaranteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guarantees', function (Blueprint $table) {
            $table->id();
            $table->string('bidder_name');
            $table->integer('value');
            $table->enum('currency', config('currency.CURRENCY'));
            $table->integer('equ_val_sy')->nullable();
            $table->string('matter');
            $table->string('number')->unique();
            $table->date('date');
            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks')->onUpdate('cascade');
            $table->date('merit_date');
            $table->enum('type', ['تأمينات', 'سلف']);
            $table->enum('status',['محررة','مدخلة','ممددة من القسم','ممددة من البنك','مصادرة','مسيلة',]);
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
        Schema::dropIfExists('guarantees');
    }
}
