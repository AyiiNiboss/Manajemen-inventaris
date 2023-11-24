<?php

namespace App\Models;

use App\Models\BarangModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SatuanModel extends Model
{
    use HasFactory;
    protected $table = 'tb_satuan';
    protected $primarykey = 'id';
    protected $fillable = [
        'nama_satuan',
    ];

    public function barangRelasi()
    {
        return $this->hasMany(BarangModel::class, 'satuan_id', 'id');
    }
}
