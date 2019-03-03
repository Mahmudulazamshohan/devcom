<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionBookmark extends Model
{
    protected $fillable =['user_id','question_id'];
    public function question(){
    	return $this->hasOne('App\Question','id','question_id');
    }
    public function user(){
    	return $this->hasOne('App\User','id','user_id');
    }
}
