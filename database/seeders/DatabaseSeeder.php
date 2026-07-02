<?php

namespace Database\Seeders;

use App\Models\LaundryPackage;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(
            ['id' => 1],
            ['name' => 'Admin', 'display_name' => 'Administrator', 'description' => 'System administrator']
        );

        $customerRole = Role::firstOrCreate(
            ['id' => 2],
            ['name' => 'Customer', 'display_name' => 'Customer', 'description' => 'Laundry customer']
        );

        $vendorRole = Role::firstOrCreate(
            ['id' => 3],
            ['name' => 'Vendor', 'display_name' => 'Mama Fua', 'description' => 'Laundry service provider']
        );

        $riderRole = Role::firstOrCreate(
            ['id' => 4],
            ['name' => 'Rider', 'display_name' => 'Rider/Delivery', 'description' => 'Pickup and delivery rider']
        );

        User::updateOrCreate(
            ['email' => 'admin@washease.test'],
            [
                'role_id' => $adminRole->id,
                'name' => 'WashEase Admin',
                'phone_number' => '0700000001',
                'address' => 'Nairobi CBD',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'is_available' => false,
            ]
        );

        $vendor = User::updateOrCreate(
            ['email' => 'vendor@washease.test'],
            [
                'role_id' => $vendorRole->id,
                'name' => 'CleanWave Laundry',
                'phone_number' => '0700000002',
                'address' => 'Commercial Street, Nairobi',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'is_available' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'rider@washease.test'],
            [
                'role_id' => $riderRole->id,
                'name' => 'WashEase Rider',
                'phone_number' => '0700000003',
                'address' => 'Ngong Road, Nairobi',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'is_available' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer@washease.test'],
            [
                'role_id' => $customerRole->id,
                'name' => 'WashEase Customer',
                'phone_number' => '0700000004',
                'address' => 'H&B Apartments, Penthouse A3, Nairobi',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'is_available' => false,
            ]
        );

        $packages = [
            [
                'name' => 'Wash & Fold',
                'description' => 'Everyday clothing wash, dry, and fold service.',
                'pricing_type' => 'kg',
                'price_per_unit' => 120,
                'estimated_hours' => 24,
            ],
            [
                'name' => 'Dry Cleaning',
                'description' => 'Premium garment care for delicate fabrics.',
                'pricing_type' => 'item',
                'price_per_unit' => 250,
                'estimated_hours' => 48,
            ],
            [
                'name' => 'Ironing',
                'description' => 'Fresh pressing and wrinkle removal.',
                'pricing_type' => 'item',
                'price_per_unit' => 60,
                'estimated_hours' => 12,
            ],
            [
                'name' => 'Bedding',
                'description' => 'Cleaning service for duvets, sheets, and blankets.',
                'pricing_type' => 'item',
                'price_per_unit' => 300,
                'estimated_hours' => 48,
            ],
            [
                'name' => 'Curtains',
                'description' => 'Deep curtain cleaning and refresh service.',
                'pricing_type' => 'item',
                'price_per_unit' => 400,
                'estimated_hours' => 72,
            ],
            [
                'name' => 'Shoes',
                'description' => 'Professional shoe cleaning and detailing.',
                'pricing_type' => 'pair',
                'price_per_unit' => 350,
                'estimated_hours' => 24,
            ],
        ];

        foreach ($packages as $package) {
            LaundryPackage::updateOrCreate(
                ['name' => $package['name']],
                array_merge($package, [
                    'vendor_id' => $vendor->id,
                    'is_active' => true,
                ])
            );
        }
    }
}
