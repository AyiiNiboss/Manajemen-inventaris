<?php

namespace App\Models;

use App\Models\User;
use App\Models\DetailPengeluaranModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengeluaranModel extends Model
{
    use HasFactory;
    protected $table = 'tb_barang_keluar';
    protected $primarykey = 'id';
    protected $fillable = [
        'user_id',
        'tgl',
        'catatan',
        'catatan_tolak',
        'status'
    ];

    public function userRelasi(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function detailPengeluaranRelasi() {
        return $this->hasMany(DetailPengeluaranModel::class, 'barangkeluar_id');
    }
}
