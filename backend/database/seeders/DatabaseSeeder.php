<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Passwords are hashed automatically by the User model cast.
        User::create(['name' => 'Administrator', 'username' => 'admin', 'password' => 'admin123', 'role' => 'admin']);
        User::create(['name' => 'Juan Dela Cruz', 'username' => 'driver1', 'password' => 'driver123', 'role' => 'driver']);

        Store::create(['name' => 'Quezon Mart', 'code' => 'QM-001', 'address' => 'Quezon City', 'status' => 'active']);
        Store::create(['name' => 'Makati Grocer', 'code' => 'MG-002', 'address' => 'Makati City', 'status' => 'active']);
        Store::create(['name' => 'Pasig Fresh', 'code' => 'PF-003', 'address' => 'Pasig City', 'status' => 'inactive']);
    }
}
