<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agensi extends Model
{
    protected $table = 'agensi';

    protected $fillable = [
        'nama_agensi',
        'no_tel_agensi',
        'website',
        'pic_nama',
        'pic_telefon',
        'pic_email',
        'nama_pic',
        'no_tel_pic',
        'emel_pic',
        'sektor_id',
        'jenis_perniagaan_perhubungan',
        'keterangan',
    ];

    public function sektor()
    {
        return $this->belongsTo(Sektor::class, 'sektor_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'agensi_id', 'id');
    }

    public function inventori()
    {
        return $this->hasMany(Inventori::class, 'agensi_id');
    }
}
