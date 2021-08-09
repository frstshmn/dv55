<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    /** Test view
     * @method GET
     * @param id - Test ID
     * @return HTTP_CODE
    */
    public function show($id){

        $test = Test::where('id', $id)->first();
        $questions = Question::where('test_id', $test->id)->get();
        $answered = false;
        foreach ($questions as $question) {
            if(!empty(Answer::where([['question_id', $question->id],['user_id', Auth::user()->id],])->first())){
                $answered = true;
            }
        }

        if($answered){
            $correct_answers = 0;

            $test = Test::where('id', $id)->first();
            $questions = Question::where('test_id', $id)->get();
            $user = Auth::user();
                foreach($questions as $question){
                    $answer = Answer::where([
                        ['user_id', '=', $user->id],
                        ['question_id', '=', $question->id]
                    ])->first();

                    if($question->correct_answer == $answer->answer){
                        $correct_answers++;
                    }
                }

                return view('user.resultsidebar', [
                    'result' => round((($correct_answers*100)/$questions->count()), 2),
                    'user' => $user,
                    'test' => $test
                ]);
            }
        else{
            return view('user.test', [
                'test' => $test
            ]);
        }

    }

    public function getJSON($id){

        $test = Test::where('id', $id)->first();

        return json_encode($test);
    }

    public function getQuestions($id){

        $test = Test::where('id', $id)->first();

        return view('user.questions', [
            'test' => $test
        ]);
    }

    public function create(Request $request){
        $test = new Test();
        $test->time = $request->time;
        $test->module_id = $request->module_id;
        $test->save();

        for ($i = 1; $i <= $request->count; $i++) {
            $question = new Question();

            $q = 'question_'.$i;
            $c = 'correct_answer_'.$i;

            $v1 = 'variant_1_'.$i;
            $v2 = 'variant_2_'.$i;
            $v3 = 'variant_3_'.$i;
            $v4 = 'variant_4_'.$i;

            $question->question = $request->{$q};
            $question->image_path = 'none';
            $question->correct_answer = $request->{$c};
            $question->v_1 = $request->{$v1};
            $question->v_2 = $request->{$v2};
            $question->v_3 = $request->{$v3};
            $question->v_4 = $request->{$v4};

            $question->test_id = $test->id;
            $question->save();
        }

        if($request->duplicate == 'on'){
            $test = new Test();
            $test->time = $request->time;
            $test->module_id = $request->module_id;
            $test->save();

            for ($i = 1; $i <= $request->count; $i++) {
                $question = new Question();

                $q = 'question_'.$i;
                $c = 'correct_answer_'.$i;

                $v1 = 'variant_1_'.$i;
                $v2 = 'variant_2_'.$i;
                $v3 = 'variant_3_'.$i;
                $v4 = 'variant_4_'.$i;

                $question->question = $request->{$q};
                $question->image_path = 'none';
                $question->correct_answer = $request->{$c};
                $question->v_1 = $request->{$v1};
                $question->v_2 = $request->{$v2};
                $question->v_3 = $request->{$v3};
                $question->v_4 = $request->{$v4};

                $question->test_id = $test->id;
                $question->save();
            }
        }

        return redirect()->back();
        // return dd($request);
    }

    public function update(Request $request){
        $test = Test::where('id', $request->test_id)->first();
        $test->time = $request->time;
        $test->save();

        $questions = Question::where('test_id', $request->test_id)->get();

        foreach ($questions as $question) {

            $q = 'question_'.$question->id;
            $c = 'correct_answer_'.$question->id;
            $v1 = 'variant_1_'.$question->id;
            $v2 = 'variant_2_'.$question->id;
            $v3 = 'variant_3_'.$question->id;
            $v4 = 'variant_4_'.$question->id;

            if(empty($request->{$q})){
                $question->delete();
            }
            else {
                $question->question = $request->{$q};

                $question->image_path = 'none';
                $question->correct_answer = $request->{$c};
                $question->v_1 = $request->{$v1};
                $question->v_2 = $request->{$v2};
                $question->v_3 = $request->{$v3};
                $question->v_4 = $request->{$v4};

                $question->save();
            }
        }

        for ($i = 1; $i <= $request->count - $questions->count(); $i++) {
            $question = new Question();

            $q = 'new_question_'.$i;
            $c = 'new_correct_answer_'.$i;

            $v1 = 'new_variant_1_'.$i;
            $v2 = 'new_variant_2_'.$i;
            $v3 = 'new_variant_3_'.$i;
            $v4 = 'new_variant_4_'.$i;

            $question->question = $request->{$q};
            $question->image_path = 'none';
            $question->correct_answer = $request->{$c};
            $question->v_1 = $request->{$v1};
            $question->v_2 = $request->{$v2};
            $question->v_3 = $request->{$v3};
            $question->v_4 = $request->{$v4};

            $question->test_id = $test->id;
            $question->save();
        }

        return redirect()->back();
    }

    /** Delete test by ID
     * @method DELETE
     * @param request - ID of test need to delete
     * @return HTTP_CODE
    */
    public function delete(Request $request){
        $test = Test::where('id', $request->id)->first();

            $questions = Question::where('test_id', $test->id)->get();

                foreach ($questions as $question){

                    $answers = Answer::where('question_id', $question->id)->get();

                    foreach ($answers as $answer){
                        $answer->delete();
                    }

                    $question->delete();
                }



        $test->delete();


        return redirect()->back();
    }
}
