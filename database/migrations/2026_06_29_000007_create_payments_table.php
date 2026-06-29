<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('merchant_request_id')->unique()->nullable();
            $table->string('checkout_request_id')->unique()->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('mpesa_receipt_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('status')->default('PENDING');
            $table->string('payment_method')->default('M-Pesa');
            $table->timestamps();

            $table->index('merchant_request_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};