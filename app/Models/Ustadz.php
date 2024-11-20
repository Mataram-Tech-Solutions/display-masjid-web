<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ustadz extends Model
{
    use HasFactory;
    protected $table = 'ustadz';

    public function ustadz()
    {
        return $this->hasMany(Jadwal::class, 'name');
    }

    public function khatib()
    {
        return $this->hasMany(Jadwal::class, 'name');
    }
}
