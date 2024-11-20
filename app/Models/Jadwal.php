<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';

    public function ustadz()
    {
        return $this->belongsTo(Ustadz::class, 'imam');
    }

    public function khatib()
    {
        return $this->belongsTo(Ustadz::class, 'khatib');
    }
}
