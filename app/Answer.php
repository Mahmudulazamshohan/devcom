<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $fillable = ['user_id',
                          'question_id',
                          'question_text',
                          'date','month'];
    public function question(){
    	return $this->hasOne('App\Question','question_id','id');
    }  
    public function profile(){
    	return $this->hasOne('App\Profile','user_id','user_id');
    }      
    public function user(){
      return $this->hasOne('App\User','id','user_id');
    } 
    public function totalvote(){
      return AnswerVote::where('answer_id',$this->id)->sum('vote');
    }             
}
