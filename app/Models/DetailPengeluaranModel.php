<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengeluaranModel extends Model
{
    use HasFactory;
    protected $table = 'tb_detail_barang_keluar';
    protected $primarykey = 'id';
    protected $fillable = [
        'barangkeluar_id',
        'barang_id',
        'jumlah',
    ];

    public function pengeluaranRelasi(){
        return $this->belongsTo(PengeluaranModel::class, 'barangkeluar', 'id');
    }

    public function barangRelasi(){
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }
}
