<?php

namespace App\Models;

use App\Models\KategoriPuncaRisiko;
use Illuminate\Database\Eloquent\Model;

class PuncaRisiko extends Model
{
    //
    protected $table = 'punca_risiko';
    protected $fillable = [
        'punca_risiko',
        'kategori_punca_risiko_id',
        'pelan_mitigasi',
    ];

    public function kategoriPuncaRisiko()
    {
        return $this->belongsTo(KategoriPuncaRisiko::class, 'kategori_punca_risiko_id');
    }
}
