<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    /** Course view
     * @method GET
     * @param id - course ID
     * @return HTTP_CODE
    */
    public function show($id){

        $course = Course::where('id', $id)->first();

        return view('course', [
            'course' => $course
        ]);
    }

    /** Get JSON-foratted data of course by ID
     * @method GET
     * @param id - ID of course
     * @return HTTP_CODE
    */
    public function getJSON($id){

        $course = Course::where('id', $id)->first();

        return json_encode($course);
    }

    /** Create new course
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

    /** Update existing course
     * @method PUT
     * @param request - values to insert into course table
     * @return HTTP_CODE
    */
    public function update(Request $request){

        $course = Course::where('id', $request->identifier)->first();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->save();

        return redirect()->back();
    }

    /** Delete course by ID
     * @method DELETE
     * @param request - ID of course need to delete
     * @return HTTP_CODE
    */
    public function delete(Request $request){

        $request->validate([
            'id' => 'required',
        ]);

        $course = Course::where('id', $request->id)->first();

            $modules = Module::where('course_id', $course->id);
            $modules->delete();

        $course->delete();

        return redirect()->back();
    }

}
