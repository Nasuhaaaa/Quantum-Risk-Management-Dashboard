<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriRisiko extends Model
{
    //
    protected $table = 'kategori_risiko';
    protected $fillable = [
        'kategori_risiko',
    ];

    public function subKategoriRisiko()
    {
        return $this->hasMany(SubKategoriRisiko::class, 'kategori_risiko_id');
    }
}
