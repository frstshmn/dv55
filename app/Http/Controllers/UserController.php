<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCourses;
use App\Models\Answer;
use Illuminate\Support\Facades\Hash;

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

    // /** Update existing course
    //  * @method PUT
    //  * @param request - values to insert into course table
    //  * @return HTTP_CODE
    // */
    // public function update(Request $request){

    //     $course = Course::where('id', $request->identifier)->first();
    //     $course->title = $request->title;
    //     $course->description = $request->description;
    //     $course->save();

    //     return redirect()->back();
    // }

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
}
