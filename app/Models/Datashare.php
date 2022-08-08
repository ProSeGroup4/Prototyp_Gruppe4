<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datashare extends Model
{
    use HasFactory;

    protected $table = 'datashare';

    protected $fillable = [
        'Optimieren',
        'Populationsgroeße',
        'MaxDurchlaufzeit',
    ];
}
