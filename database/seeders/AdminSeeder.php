<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@rgstore.test')->exists()) {
            User::create([
                'name' => 'Admin RGStore',
                'email' => 'admin@rgstore.test',
                'password' => Hash::make('Admin12345!'),
                'role' => 'admin',
            ]);
        }
    }
}