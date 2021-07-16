<?php

namespace App\Http\Controllers;

use App\Models\UserCourses;
use Illuminate\Http\Request;

class UserCoursesController extends Controller
{
    public function create(Request $request){

        $usercourses = UserCourses::where([
            ['user_id', '=', $request->user_id],
            ['course_id', '=', $request->course_id],
        ])->first();

        if(empty($usercourses)){
            $usercourses = new UserCourses();
            $usercourses->user_id = $request->user_id;
            $usercourses->course_id = $request->course_id;
            $usercourses->save();
        }

        return redirect()->back();
    }

    public function delete(Request $request){

        $usercourses = UserCourses::where([
            ['user_id', '=', $request->user_id],
            ['course_id', '=', $request->course_id],
        ])->first();
        $usercourses->delete();
    }
}
