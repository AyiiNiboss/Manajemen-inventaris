<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleModel extends Model
{
    use HasFactory;
    protected $table = 'tb_role';
    protected $primarykey = 'id';
    protected $fillable = [
        'nama_role',
    ];

    public function userRelasi()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
