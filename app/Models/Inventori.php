<?php

namespace App\Models;

use App\Models\SBOM;
use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{
    protected $table = 'inventori';

    protected $fillable = [
        'agensi_id',
        'jenis_aset',
        'nama_aset',
        'lokasi_pemilik',
        'sistem_legasi',
        'catatan',
    ];

    public function agensi()
    {
        return $this->belongsTo(Agensi::class, 'agensi_id');
    }

    public function sbom()
    {
        return $this->hasMany(SBOM::class, 'inventori_id');
    }
}
