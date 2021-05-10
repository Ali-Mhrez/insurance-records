<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuaranteeResolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guarantee_resolutions', function (Blueprint $table) {
            $table->id();
            $table->enum('issued_by', ['مجلس الإدارة']);
            $table->string('title');
            $table->date('date');
            $table->text('cause');
            $table->integer('guarantee_id')->unsigned();
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
        Schema::dropIfExists('guarantee_resolutions');
    }
}
