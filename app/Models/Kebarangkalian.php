<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kebarangkalian extends Model
{
    protected $table = 'kebarangkalian';
    protected $primaryKey = 'kebarangkalian_id';

    protected $fillable = [
        'tahap',
        'skala',
    ];
}
