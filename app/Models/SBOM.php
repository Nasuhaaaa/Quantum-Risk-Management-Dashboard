<?php

namespace App\Models;

use App\Models\Inventori;
use App\Models\CBOM;
use Illuminate\Database\Eloquent\Model;

class SBOM extends Model
{
    protected $table = 'sbom';

    protected $fillable = [
        'inventori_id',
        'komponen_versi',
        'sub_komponen',
        'url',
        'mod_perkhidmatan',
        'language_framework',
        'modules_libraries',
        'external_apis_services',
        'in_house_vendor',
        'nama_vendor',
        'kepakaran_kriptografi',
    ];

    public function inventori()
    {
        return $this->belongsTo(Inventori::class, 'inventori_id');
    }

    public function cbom()
    {
        return $this->hasMany(CBOM::class, 'sbom_id');
    }
}
