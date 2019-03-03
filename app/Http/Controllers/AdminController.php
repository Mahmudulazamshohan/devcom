<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Question;
use App\QuestionCategories;
use App\TestQuestion;

class AdminController extends Controller
{

    public function __construct(){
    	$data = [];
    	$this->middleware('auth:admin');
    }
    public function dashboard(){
    	$data['users'] =User::orderBy('id','desc')->paginate(3);
    	$data['questions'] = Question::orderBy('id','desc')->limit(5)->get();
    	$data['total'] = User::count();

    	return view('admin.dashboard',$data);
    }
    public function addQuestion(){
    	$data['questions'] =QuestionCategories::all();
    	return view('admin.add-question',$data);
    }
    public function storeQuestion(Request $r){
    	$this->validate($r,[
    		'title'=>'required',
    		'correct'=>'required'
    	]);
    	if(count($r->options) > 3){
    		return redirect()->back();
    	}

    	$options = implode(',', $r->options);
    	TestQuestion::create([
    		'question_category_id'=>$r->question_category_id,
    		'question_string'=>$r->title,
    		'correct'=>$r->correct,
    		'wrong'=>$options
    	]);
    	return redirect()->back()->with('message','Question Created successfully');
    }
    public function viewQuestion(){
    	$data['questions'] =TestQuestion::paginate(10);
    	return view('admin.view-question',$data);
    }
    public function questionCategoryView(){
    	$data['questions'] = QuestionCategories::orderBy('id','desc')->paginate(10);
    	return view('admin.question-category-view',$data);
    }
    public function addQuestionCategory(){
        return view('admin.add-question-category');
    }
     public function storeQuestionCategory(Request $r){
        $this->validate($r,[
            'name'=>'required'
        ]);
        QuestionCategories::create([
            'name'=>$r->name
        ]);

        return redirect()->back()
                         ->with('type','success')
                         ->with('message','Category Added successfully');

     }

}
