<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Test;
use App\Models\Answer;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    /** Create answers
     * @method DELETE
     * @param request - Answers data
     * @return JSON
    */
    public function create(Request $request){

        $questions = Question::where('test_id', $request->test_id)->get();

        foreach($questions as $question){

            $a = 'question_answer_'.$question->id;

            $answer = new Answer();
            $answer->question_id = $question->id;
            $answer->user_id = Auth::user()->id;
            if(empty($a)){
                $answer->answer = 0;
            } else {
                $answer->answer = $request->{$a};
            }
            $answer->save();

        }

        return redirect()->route('results', [
            'user_id' => Auth::user()->id,
            'test_id' => $request->test_id
        ]);
    }

    /** Show result
     * @method DELETE
     * @param request - Test ID and user ID
     * @return JSON
    */
    public function showResults(Request $request){

        $correct_answers = 0;

        $test = Test::where('id', $request->test_id)->first();
        $questions = Question::where('test_id', $request->test_id)->get();
        if(Auth::user()->is_admin){
            $user = User::where('id', $request->user_id)->first();
        } else {
            $user = Auth::user();
        }
            foreach($questions as $question){
                $answer = Answer::where([
                    ['user_id', '=', $user->id],
                    ['question_id', '=', $question->id]
                ])->first();

                if($question->correct_answer == $answer->answer){
                    $correct_answers++;
                }
            }

            return view('user.results', [
                'result' => round((($correct_answers*100)/$questions->count()), 2),
                'user' => $user,
                'test' => $test
            ]);

    }
}
