<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerVote extends Model
{
    protected $fillable = ['user_id',
                          'answer_id',
                          'question_id',
                          'vote'];

}
