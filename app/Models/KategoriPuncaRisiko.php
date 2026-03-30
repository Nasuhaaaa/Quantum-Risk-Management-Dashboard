<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPuncaRisiko extends Model
{
    //
    protected $table = 'kategori_punca_risiko';
    protected $fillable = [
        'kategori_punca_risiko',
    ];

    public function puncaRisiko()
    {
        return $this->hasMany(PuncaRisiko::class, 'kategori_punca_risiko_id');
    }
}
