<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Material;
use App\Models\UserComplection;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /** Get JSON-foratted data of module by ID
     * @method GET
     * @param id - ID of module
     * @return HTTP_CODE
    */
    public function getJSON($id){

        $module = Module::where('id', $id)->first();

        return json_encode($module);
    }

    /** Get JSON-foratted data of material by module ID
     * @method GET
     * @param id - ID of module
     * @return HTTP_CODE
    */
    public function getMaterials($module_id){

        $materials = Material::where('module_id', $module_id)->get();

        return json_encode($materials);
    }

    /** Create new module
     * @method POST
     * @param request - values to insert into module table
     * @return HTTP_CODE
    */
    public function create(Request $request){

        $request->validate([
            'title' => 'bail|required|max:255',
            'course_id' => 'required'
        ]);

        $module = new Module();
        $module->title = $request->title;
        $module->course_id = $request->course_id;
        $module->save();

        return redirect()->back();
    }

    /** Update existing module
     * @method PUT
     * @param request - values to insert into module table
     * @return HTTP_CODE
    */
    public function update(Request $request){

        $module = Module::where('id', $request->identifier)->first();
        $module->title = $request->title;
        $module->course_id = $request->course_id;
        $module->save();

        return redirect()->back();
    }

    /** Delete module by ID
     * @method DELETE
     * @param request - ID of module need to delete
     * @return HTTP_CODE
    */
    public function delete(Request $request){

        $request->validate([
            'id' => 'required',
        ]);

        $module = Module::where('id', $request->id)->first();

            $materials = Material::where('module_id', $module->id)->get();

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




        $module->delete();

        return redirect()->back();
    }
}
