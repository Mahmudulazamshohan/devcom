<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PersonController extends Controller
{

	public function __construct(){
      // $this->middleware('auth');
	}
	public function questionApi(){
		$data = [];
		
		for($i=0;$i<=10;$i++){
			$items = [
			  'question_string'=> "What color is the shohan?".$i,
			  'choices'=> [
			    'correct'=>"Blue",
			    'wrong'=>["Pink", "Orange", "Green"]
			  ]
			];
		   array_push($data,$items);
		}
		return response()->json($data);
	}

}
