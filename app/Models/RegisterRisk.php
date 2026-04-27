<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterRisk extends Model
{
    //
    protected $table = 'risk_register';
    protected $fillable = [
        'cbom_id',
        'risiko_id',
        'pemilik_risiko',
        'punca_risiko_id',
        'impak',
        'kemungkinan',
        'impak_id',
        'kebarangkalian_id',
        'skor_risiko',
        'tahap_risiko',
        'tahap_risiko_id',
        'kawalan_sedia_ada',
        'pelan_mitigasi'
    ];

    public function cbom()
    {
        return $this->belongsTo(CBOM::class, 'cbom_id');
    }

    public function risiko()
    {
        return $this->belongsTo(Risiko::class, 'risiko_id');
    }

    public function puncaRisiko()
    {
        return $this->belongsTo(PuncaRisiko::class, 'punca_risiko_id');
    }

    public function impak()
    {
        return $this->belongsTo(Impak::class, 'impak_id');
    }

    public function kebarangkalian()
    {
        return $this->belongsTo(Kebarangkalian::class, 'kebarangkalian_id');
    }

    public function tahapRisiko()
    {
        return $this->belongsTo(TahapRisiko::class, 'tahap_risiko_id');
    }
}
