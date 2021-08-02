<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    /** JSON-formated data of question by test ID
     * @method DELETE
     * @param request - ID of test
     * @return JSON
    */
    public function getJSON($test_id){
        $questions = Question::where('test_id', $test_id)->get();

        return json_encode($questions);
    }
}
