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

    public function allMaterialsChecked(){
        $materials = Material::where('module_id', $this->id)->get();

        $checked = true;

        foreach($materials as $material){
            if(!$material->isChecked()){
                $checked = false;
            }
        }

        return $checked;
    }
}
