<?php

namespace App\Models;

use App\Models\BarangModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StokModel extends Model
{
    use HasFactory;
    protected $table = 'tb_stok_barang';
    protected $primarykey = 'id';
    protected $fillable = [
        'barang_id',
        'tgl_masuk',
        'sisa_stok',
    ];

    public function barangRelasi(){
        return $this->belongsTo(BarangModel::class, 'barang_id', 'id');
    }

}
