<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public $timestamps = false;
    use HasFactory;
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
