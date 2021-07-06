<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function show($id){

        $test = Test::where('id', $id)->first();

        return view('user.test', [
            'test' => $test
        ]);
    }

    public function getQuestions($id){

        $test = Test::where('id', $id)->first();

        return view('user.questions', [
            'test' => $test
        ]);
    }
}
