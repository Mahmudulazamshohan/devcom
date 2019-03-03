<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\TestQuestion;
use App\TestScore;
use Auth;
class PersonController extends Controller
{

	public function __construct(){
       $this->middleware('auth');
	}
	public function questionApi(Request $r){
		$data = [];
		$testQuestions = TestQuestion::where('question_category_id',$r->question_category_id)->get();
		foreach($testQuestions as $t){

			$items = [
			  'question_string'=> $t->question_string,
			  'choices'=> [
			    'correct'=>$t->correct,
			    'wrong'=>explode(',',$t->wrong)
			  ]
			];
		   array_push($data,$items);
		}
		//shuffle($data);
		return response()->json($data);
	}
	public function storeScore(Request $r){
		$t = TestScore::create([
				'user_id'=>Auth::id(),
				'title'=>$r->title,
				'score'=>$r->score,
			]);
		return  response()->json($t);
	}

}
