<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Test extends Model
{
    public $timestamps = false;
    use HasFactory;
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function module(){
        return $this->belongsTo(Module::class);
    }

    public function isAnswered(){
        $test = Test::where('id', $this->id)->first();
        $questions = Question::where('test_id', $test->id)->get();
        $answered = false;
        foreach ($questions as $question) {
            if(!empty(Answer::where([['question_id', $question->id],['user_id', Auth::user()->id]])->first())){
                $answered = true;
            }
        }

        return $answered;
    }

    public function isCompleted($user_id){
        $correct_answers = 0;

        // $test = Test::where('id', $this->id)->first();
        // $user = User::where('id', Auth::user()->id)->first();
        $questions = Question::where('test_id', $this->id)->get();

        if($questions->count() <= 0){
            return false;
        } else {

            foreach($questions as $question){
                $answer = Answer::where([
                    ['user_id', $user_id],
                    ['question_id', $question->id]
                ])->first();

                if(!empty($answer)){
                    if($question->correct_answer == $answer->answer){
                        $correct_answers++;
                    }
                }
            }

            if (($correct_answers*100)/$questions->count() >= 70){
                return true;
            } else {
                return false;
            }
        }
    }
}
