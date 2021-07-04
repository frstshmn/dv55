<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function show($id){

        $material = Material::where('id', $id)->first();

        return view('material', [
            'material' => $material
        ]);
    }
}
