<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained(); // optional kalau via room_loan
            $table->foreignId('room_loan_id')->nullable()->constrained();
            $table->foreignId('item_id')->constrained();
            $table->integer('jumlah');
            $table->string('status')->default('dipinjam');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_loans');
    }
};
