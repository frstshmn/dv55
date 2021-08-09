<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserCourses;
use App\Models\Module;
use App\Models\Material;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use App\Models\UserComplection;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

    /** Course view
     * @method GET
     * @param id - course ID
     * @return HTTP_CODE
    */
    public function show($id){

        $course = Course::where('id', $id)->first();
        $avaliable = UserCourses::where([['user_id', Auth::user()->id],['course_id', $course->id]])->first();
        if(!empty($avaliable)){
            return view('user.course', [
                'course' => $course
            ]);
        } else {
            return redirect()->back();
        }
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

        $usercomplection = new UserComplection();
        $usercomplection->user_id = Auth::user()->id;
        $usercomplection->course_id = $course->id;
        $usercomplection->save();

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

                foreach ($modules as $module){
                    $materials = Material::where('module_id', $module->id);
                    foreach($materials as $material){
                        $usercomplection = UserComplection::where('material_id', $material->id);
                        $usercomplection->delete();
                        $material->delete();
                    }

                    $tests = Test::where('module_id', $module->id)->get();
                    foreach($tests as $test){
                        $questions = Question::where('test_id', $test->id)->get();

                            foreach ($questions as $question){

                                $answers = Answer::where('question_id', $question->id)->get();

                                foreach ($answers as $answer){
                                    $answer->delete();
                                }

                                $question->delete();
                            }

                        $test->delete();
                    }
                }

            $modules->delete();

        $course->delete();

        return redirect()->back();
    }

    /** Get sidebar by ID
     * @method DELETE
     * @param request - ID of course
     * @return HTTP_CODE
    */
    public function getModule(Request $request){

        $module = Module::where('id', $request->id)->first();

        return view('user.sidebar.module', [
            'module' => $module
        ]);
    }

    public function getTotal(Request $request){

        $course = Course::where('id', $request->id)->first();

        return view('user.sidebar.total', [
            'course' => $course
        ]);
    }

}
