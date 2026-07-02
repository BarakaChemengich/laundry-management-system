<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'return_address')) {
                $table->text('return_address')->nullable()->after('collection_address');
            }

            if (!Schema::hasColumn('orders', 'return_date')) {
                $table->date('return_date')->nullable()->after('scheduled_pickup_at');
            }

            if (!Schema::hasColumn('orders', 'delivery_option')) {
                $table->string('delivery_option')->nullable()->after('return_date');
            }

            if (!Schema::hasColumn('orders', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('delivery_option');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = ['return_address', 'return_date', 'delivery_option', 'phone_number'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
