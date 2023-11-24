<?php

namespace App\Models;

use App\Models\DetailPembelianModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembelianModel extends Model
{
    use HasFactory;
    protected $table = 'tb_barang_masuk';
    protected $primarykey = 'id';
    protected $fillable = [
        'supplier_id',
        'tgl',
        'catatan',
    ];

    public function supplierRelasi(){
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'id');
    }

    public function detailPembelianRelasi() {
        return $this->hasMany(DetailPembelianModel::class, 'barangmasuk_id');
    }
}
