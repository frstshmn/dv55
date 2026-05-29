<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Module;
use App\Models\Test;
use App\Models\UserComplection;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function showCreate(Request $request)
    {
        $module = Module::findOrFail($request->module_id);
        $course = $module->course;
        return view('admin.new.material_form', [
            'material' => null,
            'module'   => $module,
            'course'   => $course,
        ]);
    }

    public function showEdit($id)
    {
        $material = Material::findOrFail($id);
        $module   = $material->module;
        $course   = $module->course;
        return view('admin.new.material_form', [
            'material' => $material,
            'module'   => $module,
            'course'   => $course,
        ]);
    }

    /** Get material by ID
     * @method GET
     * @param id - ID of material
     * @return HTTP_CODE
    */
    public function show($id){

        $material = Material::where('id', $id)->first();
        $next_id = Material::where([
            ['id', '>', $id],
            ['module_id', '=', $material->module->id]
        ])->min('id');

        $test = Test::where('module_id', $material->module->id)->first();

        $next_material = Material::where('id', $next_id)->first();
        return view('user.material', [
            'material' => $material,
            'next_material' => $next_material,
            'test' => $test
        ]);
    }

    /** Get JSON-foratted data of material by ID
     * @method GET
     * @param id - ID of material
     * @return HTTP_CODE
    */
    public function getJSON($id){

        $material = Material::where('id', $id)->first();

        return json_encode($material);
    }

    /** Create new material
     * @method POST
     * @param request - values to insert into material table
     * @return HTTP_CODE
    */
    public function create(Request $request){

        $request->validate([
            'title' => 'bail|required|max:255',
            'module_id' => 'required',
            'code' => 'required'
        ]);

        $material = new Material();
        $material->title = $request->title;
        $material->module_id = $request->module_id;
        $material->code = $request->code;
        $material->save();

        $courseId = Module::find($request->module_id)?->course?->id;
        return redirect('/admin?course=' . $courseId)->with('success', 'Матеріал створено');
    }

    /** Update existing material
     * @method PUT
     * @param request - values to insert into material table
     * @return HTTP_CODE
    */
    public function update(Request $request){

        $material = Material::where('id', $request->id)->first();
        $material->title = $request->title;
        $material->code = $request->code;
        $material->save();

        $courseId = $material->module?->course?->id;
        return redirect('/admin?course=' . $courseId)->with('success', 'Матеріал збережено');
    }

    /** Delete material by ID
     * @method DELETE
     * @param request - ID of material need to delete
     * @return HTTP_CODE
    */
    public function delete(Request $request){

        $request->validate([
            'id' => 'required',
        ]);

        $material = Material::where('id', $request->id)->first();
        $courseId = $material->module?->course?->id;
        UserComplection::where('material_id', $material->id)->delete();
        $material->delete();

        return redirect('/admin?course=' . $courseId)->with('success', 'Матеріал видалено');
    }
}
