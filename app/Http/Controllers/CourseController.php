<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show($id){

        $course = Course::where('id', $id)->first();

        return view('course', [
            'course' => $course
        ]);
    }

    /** Create new item
     * @method POST
     * @param request - values to insert into course table
     * @return HTTP_CODE
    */
    public function create(Request $request){

        $request->validate([
            'title' => 'bail|required|unique:courses|max:255',
            'description' => 'required'
        ]);

        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->save();

        return redirect()->back();
    }

    /** Create new item
     * @method DELETE
     * @param request - ID of course need to delete
     * @return HTTP_CODE
    */
    public function delete(Request $request){

        $request->validate([
            'id' => 'required',
        ]);

        $course = Course::where('id', $request->id)->first();
        $course->delete();

        return redirect()->back();
    }
}
