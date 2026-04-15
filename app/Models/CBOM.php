<?php

namespace App\Models;

use App\Models\SBOM;
use Illuminate\Database\Eloquent\Model;

class CBOM extends Model
{
    protected $table = 'cbom';

    protected $fillable = [
        'sbom_id',
        'algoritma_kriptografi',
        'panjang_kunci',
        'tujuan_penggunaan',
        'library_modules',
        'kategori_data',
        'sokongan_crypto_agility',
    ];

    public function sbom()
    {
        return $this->belongsTo(SBOM::class, 'sbom_id');
    }

    public function riskRegisters()
    {
        return $this->hasMany(RegisterRisk::class, 'cbom_id');
    }
}
