<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kajian extends Model
{
    use HasFactory;
    protected $table = 'kajian';

    public function pemateri()
    {
        return $this->belongsTo(Ustadz::class, 'ulama');
    }
}
