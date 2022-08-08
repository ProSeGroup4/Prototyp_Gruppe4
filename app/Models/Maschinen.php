<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maschinen extends Model
{
    use HasFactory;

    protected $table = 'maschinen';

    protected $fillable = [
        'Name',
        'is_available',
    ];
}
