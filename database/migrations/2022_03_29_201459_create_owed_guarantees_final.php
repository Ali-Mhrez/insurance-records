<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwedGuaranteesFinal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owed_guarantees_final', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guarantee_id')->unique();
            $table->foreign('guarantee_id')->references('id')->on('fguarantees')->onDelete('cascade');
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
        Schema::dropIfExists('owed_guarantees_final');
    }
}
