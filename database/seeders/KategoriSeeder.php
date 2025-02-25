<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'kategori_kode' => 'K01', 'kategori_nama' => 'Elektronik'],
            ['kategori_id' => 2, 'kategori_kode' => 'K02', 'kategori_nama' => 'Pakaian'],
            ['kategori_id' => 3, 'kategori_kode' => 'K03', 'kategori_nama' => 'Alat Tulis'],
            ['kategori_id' => 4, 'kategori_kode' => 'K04', 'kategori_nama' => 'Makanan'],
            ['kategori_id' => 5, 'kategori_kode' => 'K05', 'kategori_nama' => 'Minuman'],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
