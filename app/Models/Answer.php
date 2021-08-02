<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    // public function getQuestion(){
    //     $question = Question::where('id', $this->question_id)->first();
    //     return ucfirst($question->question);
    // }

    // public function correctAnswer(){
    //     $question = Question::where('id', $this->question_id)->first();
    //     $c = 'v_'.$question->correct_answer;
    //     return ucfirst($question->{$c});
    // }

    // public function userAnswer(){
    //     $question = Question::where('id', $this->question_id)->first();
    //     $c = 'v_'.$this->answer;
    //     return ucfirst($question->{$c});
    // }
}
