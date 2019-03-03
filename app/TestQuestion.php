<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    protected $fillable =  ['question_category_id',
							'question_string',
							'correct',
							'wrong'];

	public function questionCategories(){
		return $this->hasOne('App\QuestionCategories','id','question_category_id');
	}						
}
