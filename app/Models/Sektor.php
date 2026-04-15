<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sektor extends Model
{
    protected $table = 'sektor';

    protected $fillable = [
        'nama_sektor',
        'keterangan_sektor',
        'ketua_sektor',
        'maklumat_perhubungan_sektor',
    ];

    public function agensi()
    {
        return $this->hasMany(Agensi::class, 'sektor_id');
    }
}
