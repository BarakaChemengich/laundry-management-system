<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if role_id exists before adding
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->nullable()->after('id')->constrained('roles')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone_number');
            }
            
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('pending')->after('password');
            }
            
            if (!Schema::hasColumn('users', 'is_available')) {
                $table->boolean('is_available')->default(false)->after('status');
            }
            
            if (!Schema::hasColumn('users', 'service_area')) {
                $table->string('service_area')->nullable()->after('is_available');
            }
            
            if (!Schema::hasColumn('users', 'vehicle_type')) {
                $table->string('vehicle_type')->nullable()->after('service_area');
            }
            
            if (!Schema::hasColumn('users', 'license_plate')) {
                $table->string('license_plate')->nullable()->after('vehicle_type');
            }
            
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('license_plate');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['role_id', 'phone_number', 'address', 'status', 'is_available', 'service_area', 'vehicle_type', 'license_plate', 'last_login_at'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};