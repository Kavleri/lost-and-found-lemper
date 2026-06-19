<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            ['name' => 'Elektronik', 'description' => 'HP, Laptop, Tablet, Flashdisk, dll'],
            ['name' => 'Dokumen', 'description' => 'KTP, SIM, Kartu Mahasiswa, Buku, dll'],
            ['name' => 'Pakaian/Aksesoris', 'description' => 'Jaket, Tas, Topi, Jam Tangan, dll'],
            ['name' => 'Lainnya', 'description' => 'Barang lainnya'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
