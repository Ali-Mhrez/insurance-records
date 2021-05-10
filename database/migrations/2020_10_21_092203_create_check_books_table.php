<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_books', function (Blueprint $table) {
            $table->id();
            $table->enum('issued_by',['صادر عن القسم','وارد من البنك']);
            $table->string('title')->unique();
            $table->date('date');
            $table->integer('check_id')->unsigned();
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
        Schema::dropIfExists('check_books');
    }
}
