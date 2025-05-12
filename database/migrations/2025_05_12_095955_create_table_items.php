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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_id');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->string('item_name', 255);
            $table->enum('conditions',['good', 'lost', 'broken']);
            $table->integer('qty');
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->foreign('cat_id')->references('id')->on('categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
