<?php

namespace App\Http\Controllers;

use App\Mail\Feedback;

use App\Models\User;
use App\Models\UserCourses;
use App\Models\Course;
use App\Models\Answer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use Illuminate\Validation\Rules;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /** Get JSON-foratted data of user by ID
     * @method GET
     * @param id - ID of user
     * @return HTTP_CODE
    */
    public function getJSON($id){

        $user = User::where('id', $id)->first();

        return json_encode($user);
    }

    public function getCourses($id){

        $user = User::where('id', $id)->first();

        $courses = array();

        foreach($user->courses as $course){
            $courses[] = Course::where('id', $course->course_id)->first();
        }

        return json_encode($courses);
    }

    /** Create new user
     * @method POST
     * @param request - values to insert into user table
     * @return HTTP_CODE
    */
    public function create(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        if($request->password == $request->password_confirmation){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->is_admin = $request->is_admin;
            $user->save();

            return redirect()->back();
        } else {
            return "Entered passwords doesn't match!";
        }
    }

    /** Update existing user
     * @method PUT
     * @param request - values to insert into user table
     * @return HTTP_CODE
    */
    public function update(Request $request){

        $user = User::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->is_admin;
        if(!empty($request->password)){
            if($request->password == $request->password_confirmation){
                $user->password = Hash::make($request->password);
            } else {
                return "Entered passwords doesn't match!";
            }
        }
        $user->save();

        return redirect()->back();
    }

    /** Delete user by ID
     * @method DELETE
     * @param request - ID of user need to delete
     * @return HTTP_CODE
    */
    public function delete(Request $request){

        $request->validate([
            'id' => 'required',
        ]);

        $user = User::where('id', $request->id)->first();
        $user->delete();

        $usercourses = UserCourses::where('user_id', $request->id);
        $usercourses->delete();

        $usercourses = Answer::where('user_id', $request->id);
        $usercourses->delete();

        return redirect()->back();
    }

    public function sendMail(Request $request) {
        $name = $request->name;
        $email = $request->email;
        $content = $request->message;

        Mail::send('layouts.feedback', ['name' => $name, 'email' => $email, 'content' => $content], function ($message) {
            $message->to('theskaters75@gmail.com')->subject('DV55');
        });

        return redirect()->back();

    }
}
