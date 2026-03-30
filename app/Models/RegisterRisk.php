<?php

namespace App\Models;

use App\Models\PuncaRisiko;
use App\Models\Risiko;
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
        'skor_risiko',
        'tahap_risiko',
        'kawalan_sedia_ada',
        'pelan_mitigasi'
    ];

    public function risiko()
    {
        return $this->belongsTo(Risiko::class, 'risiko_id');
    }

    public function puncaRisiko()
    {
        return $this->belongsTo(PuncaRisiko::class, 'punca_risiko_id');
    }
}
