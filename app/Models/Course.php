<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $timestamps = false;
    use HasFactory;
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function totalScore($user_id)
    {
        $total = 0;
        $score = 0;

        $modules = Module::where('course_id', $this->id)->get();

        foreach($modules as $module){
            $materials = Material::where('module_id', $module->id)->get();
            $tests = Test::where('module_id', $module->id)->get();

            foreach($materials as $material){
                $uc = UserComplection::where([
                    ['user_id', $user_id],
                    ['material_id', $material->id]])->get();
                $score += $uc->count();
            }

            foreach($tests as $test){
                $score += ($test->isCompleted($user_id) ? 1 : 0);
            }

            $total += $materials->count() + (empty($tests) ? 0 : 1);
        }

        if($total != 0){
            return round(($score *100)/$total, 0);
        } else {
            return 0;
        }

    }
}
