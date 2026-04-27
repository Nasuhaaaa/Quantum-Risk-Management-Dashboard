<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahapRisiko extends Model
{
    protected $table = 'tahap_risiko';
    protected $primaryKey = 'tahap_risiko_id';

    protected $fillable = [
        'skor_min',
        'skor_max',
        'tahap_risiko',
    ];
}
