<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vendor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('rider_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('laundry_package_id')->nullable()->constrained()->onDelete('set null');
            $table->string('service_type')->nullable();
            $table->decimal('weight_quantity', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2);
            $table->text('collection_address');
            $table->timestamp('scheduled_pickup_at')->nullable();
            $table->string('status')->default('PENDING');
            $table->string('estimated_turnaround')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'customer_id']);
            $table->index(['status', 'vendor_id']);
            $table->index(['status', 'rider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};