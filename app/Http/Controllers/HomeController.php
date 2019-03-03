<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use Image;
use Auth;
use App\QuestionViews;
use App\AnswerVote;
use App\QuestionBookmark;
use App\QuestionCategories;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $data = [];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['questions'] = Question::orderBy('id','desc')
                                      ->paginate(5);
        $data['isMessage'] = true;
        

        return view('main.index',$data);
    }
    public function tags($tags){
        $questions = Question::orderByRaw('RAND()')
                              ->where('tags','like','%'.$tags.'%')
                              ->paginate(5);

        $data['questions'] = collect($questions)->shuffle()
                                                ->all(); 
        $data['questions'] =  $questions;
        $data['isMessage'] = true;

        return view('main.index',$data); 
    }
    public function viewImage($fileName,$width,$height){

      
       return Image::make(storage_path('app/profile/'.$fileName))
                         ->resize($width,
                                  $height)
                         ->response();
     }
    public function apiSearch(Request $r){
        
        $questions =Question::where('title','like','%'.$r->q.'%')
                            ->orWhere('tags','like','%'.$r->q.'%')
                            ->limit(5)
                            ->get();
        $temp = [];
        foreach($questions as $question){
            $temp[] = ['name'=>$question->title,
                        'description'=>$question->tags,
                       'html_url'=>route('view-question',$question->id)
                     ];
        }
        array_push($temp,[
          'name'=>'More...',
          'html_url'=>route('search-more',$r->q)
        ]);
        $arr =['items'=>$temp];
        return response()->json($arr);
    }
    public function searchMore($q){
       $questions = Question::orderByRaw('RAND()')
                              ->where('title','like','%'.$q.'%')
                              ->orWhere('tags','like','%'.$q.'%')
                              ->paginate(5);

        $data['questions'] = collect($questions)->shuffle()
                                                ->all(); 
        $data['questions'] =  $questions;
        $data['isMessage'] = true;

        return view('main.index',$data); 
    }
   public function viewQuestion($id){
          $question = Question::find($id);
          $data['question'] = $question;
          $data['answers'] = Answer::where('question_id',$id)->get();
          $data['totalanswer'] = Answer::where('question_id',$id)->count();
          $data['isMessage'] = false;  
          $data['id'] = $id;
        
          if($question){
              if(Auth::check()){
                  if(is_null(QuestionViews::where('user_id',Auth::id())
                                          ->where('question_id',$id)
                                          ->first()))
                  QuestionViews::create([
                    'user_id'=>Auth::id(),
                    'question_id'=>$id
                  ]);
                }
              return view('main.view-question',$data);
          }else{
             // return redirect()->back();
          }

     }
     public function tagsShow(Request $r){
      $data['isMessage'] = false;
      $questionCategories = QuestionCategories::all();
      $arr = [];
      if($r->has('q')){
        $questionCategories = QuestionCategories::where('name','like','%'.$r->q.'%')->get();
      }
      foreach($questionCategories as $questionCategorie){
        $count = Question::where('tags','like','%'.$questionCategorie->name.'%')->count();
        array_push($arr, ['count'=>$count,'name'=>$questionCategorie->name]);
      }

      $data['tags'] =collect($arr)->sortByDesc('count');

      return view('main.tags',$data);
     }
     public function ajaxVote(Request $r){
      $data = [];
      $result = [];
      if($this->scoreAvailable()){
        
      }
      if(is_null(AnswerVote::where('user_id',Auth::id())->where('answer_id',$r->answer_id)->first())){
        if(Auth::check()){
          $data['user_id'] = Auth::id();
          $data['answer_id'] = $r->answer_id;
          $data['question_id'] = $r->question_id;
          $answer = AnswerVote::create($data);
          $answer->vote += 1;
          $answer->save();
          $result['error'] = false;
          $result['count'] = $answer->vote;
          $result['message'] = '';
        }else{
          $result['error'] = true;
           $result['message'] = 'Already answer this question';
        }
      }else{
        $result['error'] = true;
      }
      
      return response()->json($result);
     }
     public function ajaxVoteDelete(Request $r){
      $result = [];
      if(Auth::check()){
        if(AnswerVote::where('user_id',Auth::id())
                     ->where('answer_id',$r->answer_id)
                     ->delete()){
          $result['error'] = false;
          $result['count'] = 1;
        }else{
          $result['error'] = true;
        }
      }else{
        $result['error'] = true;
      }
      return response()->json($result);
     }
     public function users(){
      $data['isMessage'] = false;
      return view('main.users',$data);
     }
     public function topUsers(){
      $data['isMessage'] = false;
      return view('main.top-users',$data);
     }
     public function mostAnswered(){
      $data['isMessage'] = true;
      $data['questions'] =  DB::select('SELECT users.name,profiles.profile_image,answers.question_id,questions.title,questions.created_at,questions.tags
               FROM (SELECT COUNT(id) as counts,answer_votes.* 
               FROM `answer_votes` GROUP by question_id) as answers 
               INNER JOIN users ON answers.user_id = users.id 
               INNER JOIN profiles On users.id = profiles.user_id
               INNER JOIN questions ON answers.question_id = questions.id
               ORDER BY counts DESC');
    
      return view('main.user-answers',$data);
     }
     public function mostVisited(){
      $data['isMessage'] = true;
      $data['questions'] =  DB::select('SELECT users.name,profiles.profile_image,answers.question_id,questions.title,questions.created_at,questions.tags
               FROM (SELECT COUNT(id) as counts,question_views.* 
               FROM `question_views` GROUP by question_id) as answers 
               INNER JOIN users ON answers.user_id = users.id 
               INNER JOIN profiles On users.id = profiles.user_id
               INNER JOIN questions ON answers.question_id = questions.id
               ORDER BY counts DESC');
      return view('main.most-visited',$data);
     }
     public function scoreAvailable(){

     }

    

}
