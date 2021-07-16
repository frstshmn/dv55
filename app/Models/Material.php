<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public $timestamps = false;
    use HasFactory;
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
