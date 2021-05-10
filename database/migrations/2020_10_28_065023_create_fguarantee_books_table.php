<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFguaranteeBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fguarantee_books', function (Blueprint $table) {
            $table->id();
            $table->enum('issued_by',['صادر عن القسم','وارد من البنك']);
            $table->string('title')->unique();
            $table->date('date');
            $table->date('new_merit')->nullable();
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
        Schema::dropIfExists('fguarantee_books');
    }
}
