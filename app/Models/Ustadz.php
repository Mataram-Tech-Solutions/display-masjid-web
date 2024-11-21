<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ustadz extends Model
{
    use HasFactory;
    protected $table = 'ustadz';

    public function jdwlustadz()
    {
        return $this->hasMany(Jadwal::class, 'id');
    }

    public function jdwlkhatib()
    {
        return $this->hasMany(Jadwal::class, 'id');
    }

    public function pemateri()
    {
        return $this->hasMany(Kajian::class, 'id');
    }
}
