<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;
    protected $table = 'tb_supplier';
    protected $primarykey = 'id';
    protected $fillable = [
        'nama_supplier',
        'alamat',
        'no_telpon',
    ];

    public function pembelianRelasi(){
        return $this->hasMany(PembelianModel::class, 'supplier_id', 'id');
    }
}
