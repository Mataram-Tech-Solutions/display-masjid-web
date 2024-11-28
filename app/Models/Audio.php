<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;
    protected $table = 'audio';

    public function audioadzan()
    {
        return $this->hasMany(Jadwal::class, 'id');
    }

    public function audiomur()
    {
        return $this->hasMany(Jadwal::class, 'id');
    }
}
