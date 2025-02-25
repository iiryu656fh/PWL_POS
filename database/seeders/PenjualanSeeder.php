<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 'user_id' => 1, 'penjualan_kode' => 'PNJ01', 'pembeli' => 'Pembeli 1', 'penjualan_tanggal' => '2025-02-01'],
            ['penjualan_id' => 2, 'user_id' => 2, 'penjualan_kode' => 'PNJ02', 'pembeli' => 'Pembeli 2', 'penjualan_tanggal' => '2025-02-02'],
            ['penjualan_id' => 3, 'user_id' => 3, 'penjualan_kode' => 'PNJ03', 'pembeli' => 'Pembeli 2', 'penjualan_tanggal' => '2025-02-03'],
            ['penjualan_id' => 4, 'user_id' => 1, 'penjualan_kode' => 'PNJ04', 'pembeli' => 'Pembeli 1', 'penjualan_tanggal' => '2025-02-03'],
            ['penjualan_id' => 5, 'user_id' => 2, 'penjualan_kode' => 'PNJ05', 'pembeli' => 'Pembeli 2', 'penjualan_tanggal' => '2025-02-03'],
            ['penjualan_id' => 6, 'user_id' => 3, 'penjualan_kode' => 'PNJ06', 'pembeli' => 'Pembeli 1', 'penjualan_tanggal' => '2025-02-04'],
            ['penjualan_id' => 7, 'user_id' => 1, 'penjualan_kode' => 'PNJ07', 'pembeli' => 'Pembeli 2', 'penjualan_tanggal' => '2025-02-04'],
            ['penjualan_id' => 8, 'user_id' => 2, 'penjualan_kode' => 'PNJ08', 'pembeli' => 'Pembeli 3', 'penjualan_tanggal' => '2025-02-04'],
            ['penjualan_id' => 9, 'user_id' => 3, 'penjualan_kode' => 'PNJ09', 'pembeli' => 'Pembeli 3', 'penjualan_tanggal' => '2025-02-05'],
            ['penjualan_id' => 10, 'user_id' => 1, 'penjualan_kode' => 'PNJ10', 'pembeli' => 'Pembeli 1', 'penjualan_tanggal' => '2025-02-06'],

        ];

        DB::table('t_penjualan')->insert($data);
    }
}
