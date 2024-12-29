<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Astronomis extends Model
{
    use HasFactory;
    protected $table = 'astronomis';

    public function waktuWilayah()
    {
        return $this->belongsTo(Gmt::class, 'gmt');
    }
}
