<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategoriRisiko extends Model
{
    //
    protected $table = 'sub_kategori_risiko';
    protected $fillable = [
        'sub_kategori_risiko',
        'kategori_risiko_id',
    ];

    public function Risiko()
    {
        return $this->hasMany(Risiko::class, 'sub_kategori_risiko_id');
    }
}
