<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')
                  ->constrained('transaksi') // Assuming the transactions table is named 'transaksis'
                  ->onDelete('cascade'); // If the related transaksi is deleted, delete the payment as well.
            $table->string('midtrans_order_id')->unique(); // Unique Midtrans order ID
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending'); // Status of payment
            $table->string('payment_type'); // Type of payment (e.g., credit_card, bank_transfer)
            $table->string('payment_url'); // URL for the payment (for redirection)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
