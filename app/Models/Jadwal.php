<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';

    public function jdwlustadz()
    {
        return $this->belongsTo(Ustadz::class, 'imam');
    }

    public function jdwlkhatib()
    {
        return $this->belongsTo(Ustadz::class, 'khatib');
    }

    public function audioadzan()
    {
        return $this->belongsTo(Audio::class, 'audio');
    }

    public function audiomur()
    {
        return $this->belongsTo(Audio::class, 'audmur');
    }
}
