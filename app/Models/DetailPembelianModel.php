<?php

namespace App\Models;

use App\Models\BarangModel;
use App\Models\PembelianModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPembelianModel extends Model
{
    use HasFactory;
    protected $table = 'tb_detail_barang_masuk';
    protected $primarykey = 'id';
    protected $fillable = [
        'barangmasuk_id',
        'barang_id',
        'jumlah',
    ];

    public function pembelianRelasi(){
        return $this->belongsTo(PembelianModel::class, 'barangmasuk_id', 'id');
    }

    public function barangRelasi(){
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }

    
}
