<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function show($id){
        return view('material', [
            'material' => $id
        ]);
    }
}
