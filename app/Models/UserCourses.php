<?php

namespace App\Models;

use App\Models\Course;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourses extends Model
{
    use HasFactory;
    public function course(){

        return $this->belongsTo(Course::class);

    }

    public static function checkUser(){
        $available_courses = UserCourses::where('user_id', Auth::user()->id)->get();

        return $available_courses;
    }
}
