<?php

namespace App\Models;

use App\Models\SubKategoriRisiko;
use Illuminate\Database\Eloquent\Model;

class Risiko extends Model
{
    //
    protected $table = 'risk_register';
    protected $fillable = [
        'nama_risiko',
        'sub_kategori_risiko_id',
    ];

    public function subKategoriRisiko()
    {
        return $this->belongsTo(SubKategoriRisiko::class, 'sub_kategori_risiko_id');
    }

    public function registerRisks()
    {
        return $this->hasMany(RegisterRisk::class, 'risiko_id');
    }
}
