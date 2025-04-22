<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetailModel extends Model
{
    use HasFactory;
    protected $table = 't_penjualan_detail'; // mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'detail_id'; // mendefinisikan primary key

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'harga',
        'jumlah'
    ];

    public function penjualan() {
        return $this->belongsTo(PenjualanModel::class, 'penjualan_id', 'penjualan_id');
    }
    public function barang() {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }
}
