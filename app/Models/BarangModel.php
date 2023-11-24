<?php

namespace App\Models;

use App\Models\StokModel;
use App\Models\SatuanModel;
use App\Models\DetailPembelianModel;
use App\Models\DetailPengeluaranModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangModel extends Model
{
    use HasFactory;
    protected $table = 'tb_barang';
    protected $primarykey = 'id';
    protected $fillable = [
        'satuan_id',
        'kode_barang',
        'nama_barang',
        'harga_satuan',
        'deskripsi',
    ];

    public function satuanRelasi()
    {
        return $this->belongsTo(SatuanModel::class, 'satuan_id', 'id');
    }

    public function stokRelasi()
    {
        return $this->hasMany(StokModel::class, 'barang_id');
    }

    public function pembelianRelasi()
    {
        return $this->hasMany(DetailPembelianModel::class, 'barang_id');
    }

    public function pengeluaranRelasi()
    {
        return $this->hasMany(DetailPengeluaranModel::class, 'barang_id');
    }
}
