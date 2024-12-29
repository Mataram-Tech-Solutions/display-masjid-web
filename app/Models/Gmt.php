<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gmt extends Model
{
    use HasFactory;
    protected $table = 'gmt';

    public function waktuWilayah()
    {
        return $this->hasMany(Gmt::class, 'id');
    }
}
