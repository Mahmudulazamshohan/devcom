<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

	/**
	 * Question
	 * @var string
	 */
   protected $table='questions';
   /**
    * Fillable array
    * @var array
    */
   protected $fillable =['user_id','title','tags','description','month','day'];
   public function user(){
     return $this->hasOne('App\User','id','user_id');
   }
   public function answer(){
    return $this->hasOne('App\Answer','user_id','user_id');
   }
   public function profile(){
    return $this->hasOne('App\Profile','user_id','user_id');
   }
   public function totalAnswers(){
    return Answer::where('question_id',$this->id)->count();
   }
   public function totalViews(){
    return QuestionViews::where('question_id',$this->id)->count();
   }
   public function totalvotes(){
    return AnswerVote::where('question_id',$this->id)->count();
   }
  
}
