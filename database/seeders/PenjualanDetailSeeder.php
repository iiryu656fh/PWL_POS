<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'detail_id'    => 1,
                'penjualan_id' => 1,
                'barang_id'    => 1,  // HP Oppo
                'harga'        => 2500000,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 2,
                'penjualan_id' => 1,
                'barang_id'    => 2,  // Laptop Asus
                'harga'        => 8000000,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 3,
                'penjualan_id' => 1,
                'barang_id'    => 3,  // TV Samsung
                'harga'        => 2000000,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 4,
                'penjualan_id' => 2,
                'barang_id'    => 4,  // Gamis Wanita
                'harga'        => 90000,
                'jumlah'       => 2,
            ],
            [
                'detail_id'    => 5,
                'penjualan_id' => 2,
                'barang_id'    => 5,  // Daster
                'harga'        => 100000,
                'jumlah'       => 2,
            ],
            [
                'detail_id'    => 6,
                'penjualan_id' => 2,
                'barang_id'    => 6,  // Celana Kargo
                'harga'        => 130000,
                'jumlah'       => 2,
            ],
            [
                'detail_id'    => 7,
                'penjualan_id' => 3,
                'barang_id'    => 7,  // Pensil
                'harga'        => 7500,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 8,
                'penjualan_id' => 3,
                'barang_id'    => 8,  // Penghapus
                'harga'        => 8500,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 9,
                'penjualan_id' => 3,
                'barang_id'    => 9,  // Buku
                'harga'        => 9500,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 10,
                'penjualan_id' => 4,
                'barang_id'    => 10, // Sambal Terasi
                'harga'        => 3000,
                'jumlah'       => 2,
            ],
            [
                'detail_id'    => 11,
                'penjualan_id' => 4,
                'barang_id'    => 11, // Onigiri
                'harga'        => 11500,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 12,
                'penjualan_id' => 4,
                'barang_id'    => 12, // Snack
                'harga'        => 11500,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 13,
                'penjualan_id' => 5,
                'barang_id'    => 13, // Aqua
                'harga'        => 20000,
                'jumlah'       => 4,
            ],
            [
                'detail_id'    => 14,
                'penjualan_id' => 5,
                'barang_id'    => 14, // Sprite
                'harga'        => 16000,
                'jumlah'       => 2,
            ],
            [
                'detail_id'    => 15,
                'penjualan_id' => 5,
                'barang_id'    => 15, // Fanta
                'harga'        => 8000,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 16,
                'penjualan_id' => 6,
                'barang_id'    => 1,  // HP Oppo
                'harga'        => 2500000,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 17,
                'penjualan_id' => 6,
                'barang_id'    => 2,  // Laptop Asus
                'harga'        => 8000000,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 18,
                'penjualan_id' => 6,
                'barang_id'    => 3,  // TV Samsung
                'harga'        => 2000000,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 19,
                'penjualan_id' => 7,
                'barang_id'    => 4,  // Gamis Wanita
                'harga'        => 45000,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 20,
                'penjualan_id' => 7,
                'barang_id'    => 5,  // Daster
                'harga'        => 55000,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 21,
                'penjualan_id' => 7,
                'barang_id'    => 6,  // Celana Kargo
                'harga'        => 130000,
                'jumlah'       => 2,
            ],
            [
                'detail_id'    => 22,
                'penjualan_id' => 8,
                'barang_id'    => 7,  // Pensil
                'harga'        => 7500,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 23,
                'penjualan_id' => 8,
                'barang_id'    => 8,  // Penghapus
                'harga'        => 8500,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 24,
                'penjualan_id' => 8,
                'barang_id'    => 9,  // Buku
                'harga'        => 9500,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 25,
                'penjualan_id' => 9,
                'barang_id'    => 10, // Sambal Terasi
                'harga'        => 3000,
                'jumlah'       => 2,
            ],
            [
                'detail_id'    => 26,
                'penjualan_id' => 9,
                'barang_id'    => 11, // Onigiri
                'harga'        => 11500,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 27,
                'penjualan_id' => 9,
                'barang_id'    => 12, // Snack
                'harga'        => 11500,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 28,
                'penjualan_id' => 10,
                'barang_id'    => 13, // Aqua
                'harga'        => 10000,
                'jumlah'       => 2,
            ],
            [
                'detail_id'    => 29,
                'penjualan_id' => 10,
                'barang_id'    => 14, // Sprite
                'harga'        => 8000,
                'jumlah'       => 1,
            ],
            [
                'detail_id'    => 30,
                'penjualan_id' => 10,
                'barang_id'    => 15, // Fanta
                'harga'        => 8000,
                'jumlah'       => 1,
            ],
        ];
        DB::table('t_penjualan_detail')->insert($data);        
    }
}
