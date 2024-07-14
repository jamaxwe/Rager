<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('email');
            $table->string('mobilenumber', 11); // Adjusted length for mobilenumber
            $table->string('address');
            $table->string('city');
            $table->string('barangay');
            $table->string('zipcode');
            $table->string('paymentmethod');
            $table->string('image')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending'); // Changed to enum
            $table->text('message')->nullable(); // Changed to text for longer messages
            $table->string('tracking_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
