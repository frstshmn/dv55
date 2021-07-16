<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses(){

        return $this->hasMany(UserCourses::class);

    }

    public function courseProgress($course_id){

        $modules = Module::where('course_id', $course_id)->first();
        $material_count = '';
        foreach($modules as $module){
            $material_count .= $module->id;
            //$materials = Material::where('module_id', $module->id)->first();
            //$material_count += $materials->count();
        }

        return $material_count;
    }
}
