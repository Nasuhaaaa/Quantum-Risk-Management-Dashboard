<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengguna extends Model
{
    protected $table = 'jenis_pengguna';
    protected $primaryKey = 'role_id';

    protected $fillable = [
        'jenis_pengguna',
        'keterangan',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'Jenis_Pengguna', 'role_id');
    }
}
