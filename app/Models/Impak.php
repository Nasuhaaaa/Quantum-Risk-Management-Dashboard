<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Impak extends Model
{
    protected $table = 'impak';
    protected $primaryKey = 'impak_id';

    protected $fillable = [
        'tahap',
        'skala',
    ];
}
