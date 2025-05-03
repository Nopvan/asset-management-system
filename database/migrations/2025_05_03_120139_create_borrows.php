<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowsTable extends Migration
{
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->integer('jumlah');
            $table->string('status')->default('pinjam'); // default status pinjam
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrows');
    }
}
