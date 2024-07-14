<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Changed to foreignId and constrained
            $table->string('item');
            $table->string('size');
            $table->unsignedInteger('quantity'); // Adjusted to unsigned integer for quantity
            $table->decimal('price', 8, 2); // Adjusted to decimal for price (8 digits total, 2 decimals)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
}
