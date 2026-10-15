<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create([
            'name' => 'rachel Admin',
            'email' => 'admin@bandeng.com',
            'password' => Hash::make('password123'),
            'phone_number' => '081325529996',
            'role' => 'admin',
        ]);

        
        User::create([
            'name' => 'Staff Samudera',
            'email' => 'karyawan@samudera.com',
            'password' => Hash::make('password123'),
            'phone_number' => '081200000001', 
            'role' => 'karyawan',
        ]);

        
        User::create([
            'name' => 'Wely Pelanggan',
            'email' => 'wely@gmail.com',
            'password' => Hash::make('password123'),
            'phone_number' => '081200000002', 
            'role' => 'pelanggan',
        ]);
    }
}