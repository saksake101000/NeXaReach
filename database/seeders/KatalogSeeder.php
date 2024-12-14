<?php

namespace Database\Seeders;

use App\Models\Katalog;
use Illuminate\Database\Seeder;

class KatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Membuat data katalog
        Katalog::create([
            'nama' => 'Katalog Item 1',
            'gambar' => 'images/katalog1.jpg', // Pastikan gambar ini ada di folder yang sesuai
            'deskripsi' => 'Deskripsi untuk Katalog Item 1',
            'harga' => 100000,
        ]);

        Katalog::create([
            'nama' => 'Katalog Item 2',
            'gambar' => 'images/katalog2.jpg', // Pastikan gambar ini ada di folder yang sesuai
            'deskripsi' => 'Deskripsi untuk Katalog Item 2',
            'harga' => 150000,
        ]);

        Katalog::create([
            'nama' => 'Katalog Item 3',
            'gambar' => 'images/katalog3.jpg', // Pastikan gambar ini ada di folder yang sesuai
            'deskripsi' => 'Deskripsi untuk Katalog Item 3',
            'harga' => 200000,
        ]);

        // Tambahkan lebih banyak data jika perlu
    }
}
