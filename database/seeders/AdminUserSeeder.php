<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin user
        User::create([
            'name' => 'Resort Owner (Super Admin)',
            'email' => 'admin@resort.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'admin_role' => 'super_admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create demo manager
        User::create([
            'name' => 'Resort Manager',
            'email' => 'manager@resort.com',
            'password' => Hash::make('manager123'),
            'role' => 'admin',
            'admin_role' => 'manager',
            'status' => 'active',
            'invited_by' => 'admin@resort.com',
            'invited_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Create demo staff
        User::create([
            'name' => 'Front Desk Staff',
            'email' => 'staff@resort.com',
            'password' => Hash::make('staff123'),
            'role' => 'admin',
            'admin_role' => 'staff',
            'status' => 'active',
            'invited_by' => 'admin@resort.com',
            'invited_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Create demo customer user
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com', 
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        echo "✅ Super Admin created: admin@resort.com / admin123\n";
        echo "✅ Manager created: manager@resort.com / manager123\n";
        echo "✅ Staff created: staff@resort.com / staff123\n";
        echo "✅ Customer created: customer@example.com / customer123\n";
    }
}
