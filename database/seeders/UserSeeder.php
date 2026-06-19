<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'rian@student.campus.edu'],
            [
                'nim_nip' => '1202190042',
                'name' => 'Rian Hidayat',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'phone' => '081234567890',
                'department' => 'Teknik Informatika',
                'is_verified' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'saya@student.campus.edu'],
            [
                'nim_nip' => '1202190021',
                'name' => 'Saya',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'phone' => '081234567870',
                'department' => 'Teknik Informatika',
                'is_verified' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@campus.edu'],
            [
                'nim_nip' => 'ADM001',
                'name' => 'Admin Lost Found',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '081234567891',
                'department' => 'IT Department',
                'is_verified' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'satpam@campus.edu'],
            [
                'nim_nip' => 'SEC001',
                'name' => 'Danu Prasetyo',
                'password' => Hash::make('satpam123'),
                'role' => 'satpam',
                'phone' => '081234567892',
                'department' => 'Keamanan Kampus',
                'is_verified' => true,
            ]
        );
    }
}
