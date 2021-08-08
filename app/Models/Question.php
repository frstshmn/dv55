<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function correctAnswer(){
        $question = Question::where('id', $this->id)->first();
        $c = 'v_'.$question->correct_answer;
        return $question->{$c};
    }

    public function userAnswer($user_id){
        $answer = Answer::where([['question_id', $this->id],['user_id', $user_id]])->first();
        $question = Question::where('id', $this->id)->first();
        $c = 'v_'.$answer->answer;
        return $question->{$c};
    }
}
