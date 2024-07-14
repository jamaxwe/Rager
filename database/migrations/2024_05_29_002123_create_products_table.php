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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->text('description');
            $table->integer('stocks_s')->default(0);
            $table->integer('stocks_m')->default(0);
            $table->integer('stocks_l')->default(0);
            $table->integer('stocks_xl')->default(0);
            $table->integer('stocks_2xl')->default(0);
            $table->integer('stocks_3xl')->default(0);
            $table->decimal('price');
            $table->string('category');
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->decimal('ratings', 3, 2)->default(0);
            $table->integer('ratings_count')->unsigned()->default(0);
            $table->boolean('unavailable')->default(false); // New column for product availability
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
