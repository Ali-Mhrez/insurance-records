<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFguaranteeResolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fguarantee_resolutions', function (Blueprint $table) {
            $table->id();
            $table->enum('issued_by', ['مجلس الإدارة']);
            $table->string('title');
            $table->date('date');
            $table->text('cause');
            $table->integer('fguarantee_id')->unsigned();
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
        Schema::dropIfExists('fguarantee_resolutions');
    }
}
