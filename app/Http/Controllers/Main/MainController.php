<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Question;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\Profile;
use Image;
use App\Answer;
use App\QuestionBookmark;
use App\QuestionCategories;
use App\Notification;
use App\Badges;
use App\Achievements;
use App\TestScore;
class MainController extends Controller
{
     public function __construct(){
       $data = [];
     	 $this->middleware('auth');
     }
     public function mainPage(){

     }
     /**
      * Add Question in this method
      */
     public function addQuestion(){
        $data['isMessage'] = false;
        $data['question_categories'] = QuestionCategories::all();                              
        return view('main.add-question',$data);
     }
     /**
      * Store Question Data to database
      * @param  Request $r [description]
      * @return [type]     [description]
      */
     public function storeQuestion(Request $r){
          $this->validate($r,[
               'title'=>'required|max:250|min:5',
               'description'=>'required|max:1000000',
               'tags'=>'required|max:1000'
          ]);

          if(count(explode(',', $r->tags)) > 6){
              session()->flash('type','danger');
              session()->flash('message','Maximum range of tags between zero to six [choose tags below six different option]');
               return redirect()->back();
          }

          $data = [
               'user_id'=>Auth::id(),
               'title' =>$r->title,
               'description'=>$r->description,
               'tags'=>$r->tags,
               'month'=>date('Y-m'),
               'day'=>date('Y-m-d')
            ];
            
          $question = Question::create($data);
          if($question){
               session()->flash('type','success');
               session()->flash('message','Question added successfully');
               return redirect()->back();
          }else{
               session()->flash('type','danger');
               session()->flash('message','Something went wrong,please try again');
               return redirect()->back();
          }
          return redirect()->back();
     }
     public function profiles(){
          $data['profile'] = Profile::where('user_id',Auth::id())->first();
          $data['isMessage'] = false;                              
  
     	return view('main.profile',$data);
     }
     public function storeProfile(Request $r){
          $this->validate($r,[
               'name'=>'required|max:1000',
               'image'=>'mimes:jpg,jpeg,png,gif'
          ]);
          $isFileUploaded = false;
          $profileImageLocation = null;
          if($r->hasFile('image')){
              $files = $r->file('image');
              $profileImageLocation = Storage::put('profile',$files);  
              if($profileImageLocation){
                $isFileUploaded = true;
              }
          }
          $profilePrevious = Profile::where('user_id',Auth::id())->first();
          $profile = null;
          if($isFileUploaded && is_null($profilePrevious)){
               $profile = Profile::create([
                              'user_id'=>Auth::id(),
                              'profile_image'=>$profileImageLocation,
                              'employment'=>$r->employment,
                              'education'=>$r->education,
                              'location'=>$r->location,
                              'language'=>$r->language
                         ]);
          }else{
               if($isFileUploaded){
                    $profile = Profile::where('user_id',Auth::id())
                                 ->update([
                                        'user_id'=>Auth::id(),
                                        'profile_image'=>$profileImageLocation,
                                        'employment'=>$r->employment,
                                        'education'=>$r->education,
                                        'location'=>$r->location,
                                        'language'=>$r->language
                                   ]);
               }else{
                    $profile = Profile::where('user_id',Auth::id())
                                 ->update([
                                        'user_id'=>Auth::id(),
                                        'employment'=>$r->employment,
                                        'education'=>$r->education,
                                        'location'=>$r->location,
                                        'language'=>$r->language
                                   ]);
               }
               session()->flash('type','success');
               session()->flash('message','Profile updated successfully');
               return redirect()->back();
               
          }
          
          if($profileImageLocation && $profile){
               session()->flash('type','success');
               session()->flash('message','Profile updated successfully');
               return redirect()->back();
          }
     }
     public function viewImage($fileName,$width,$height){
      
       return Image::make(storage_path('app/profile/'.$fileName))
                         ->resize($width,
                                  $height)
                       ->response();
     }
     
    public function testQuestion($name,$title){
     
        $data['isMessage'] = false;
        $data['id'] = $name;  
        $data['title'] =$title;                          
        return view('main.test-developer-question',$data);
    }
    public function testQuestionCategory(){
       $data['test_categories'] = QuestionCategories::paginate(8);

        return view('main.test-category',$data);
     
    }
    protected function scorePassed($q){
     $trueOrFalse =false;
     $testScore = TestScore::where('user_id',Auth::id())->get();
      $arr = [];
      foreach(explode(',',$q->tags) as $a){

          $t = TestScore::where('user_id',Auth::id())->
          where('title','=',$a)->first();
          if($t){
            if($t->score > 75){
              $trueOrFalse = true;
            }
          }
       
      }
      return  $trueOrFalse;
      
    }
     
     public function storeAnswer(Request $r){
      $q = Question::where('id',$r->question_id)->first();

      if(!$this->scorePassed($q)){
        return redirect()->back()
                         ->with('type','danger')
                         ->with('message','You must be score more than 75 on this question related ');
      }
      

      // if(!is_null($q)){

      //     session()->flash('type','danger');
      //     session()->flash('message',"You can't answer your own question");
      //     return redirect()->back();
      // }
      // if(is_null(Answer::where('user_id',Auth::id())->where('question_id',$r->question_id)->first())){
      //   $answer = Answer::create([
      //             'user_id'=>Auth::id(),
      //             'question_id'=>$r->question_id,
      //             'question_text'=>$r->question_text,
      //             'date'=>date('Y-m-d'),
      //             'month'=>date('Y-m')
      //           ]);

      //   if($answer){
      //     $c = Answer::where('user_id',Auth::id())->count();
      //     $badge = Badges::where('category','a')->where('points',$c)->first();

       
      //     session()->flash('type','success');
      //     session()->flash('message','Answer created successfully');
      //     return redirect()->back();
      //   }else{
      //     session()->flash('type','danger');
      //     session()->flash('message','Answer created failed ,please try again');
      //     return redirect()->back();
      //   }
      // }else{
      //   session()->flash('type','danger');
      //   session()->flash('message','You already answered this question');
      //   return redirect()->back();
      // }
      
     }
     public function bookmarkStore($id){
       if(Auth::check()){
        if(is_null(Question::where('user_id',Auth::id())->where('id',$id)->first())){
          if(is_null(QuestionBookmark::where('question_id',$id)->first())){
          $q = QuestionBookmark::create([
              'user_id'=>Auth::id(),
              'question_id'=>$id
             ]); 
          }
        }

        
       }
       return redirect()->back();
     }
     public function teamFiles($file,$type){
       $fileLocation = storage_path().'/app/files/'.$file;
       if(file_exists($fileLocation)){
         $headers = [];
         switch ($type) {
           case 'video':
             $headers['Content-Type']= 'video/mp4';
             break;
            case 'download':
              return response()->download($fileLocation);
              # code...
              break;
            case 'file':
              return response()->download($fileLocation);
              # code...
              break;
           
           default:
              $headers['Content-Type']= 'image/png';
             break;
         }
         
         return response()->file($fileLocation,$headers);
       }
     
     }
     public function achievements(){
       $data['isMessage'] = false;  
       $data['badges'] = Badges::all();
       //------
       $achievements = Achievements::where('user_id',Auth::id())->get();
       $data['achievements'] = $achievements;
        $data['golds'] = $achievements->where('badge','gold');
        $data['silvers'] = $achievements->where('badge','silver');
        $data['bronzes'] = $achievements->where('badge','bronze');

       return view('main.achievements',$data);
     }
     public function notifications(){
      $data['isMessage'] = false;
      
      $data['notifications'] = Notification::where('user_id',Auth::id())->orderBy('created_at','desc')->get(); 
      
      Notification::where('user_id',Auth::id())
                   ->update([
                    'view_status'=>1
                   ]);

      return view('main.notifications',$data);
     }
     public function myQuestions(){
      $data['isMessage'] = false; 
      $data['questions'] = Question::where('user_id',Auth::id())->paginate(8); 
      return view('main.my-questions',$data);
     }
     public function myAnswers(){
      $data['isMessage'] = false; 
      $data['answers'] = Answer::where('user_id',Auth::id())->paginate(5);

      return view('main.my-answers',$data);
     }
     public function editQuestion($id){
      $data['isMessage'] = false; 
      $data['question'] = Question::where('id',$id)->first();
      $data['id'] = $id;
      $data['question_categories'] =QuestionCategories::all(); 
      return view('main.edit-question',$data);
     }
     public function updateQuestion(Request $r){
      $this->validate($r,[
               'title'=>'required|max:250|min:5',
               'description'=>'required|max:1000000',
      ]);
      Question::where('id',$r->id)
              ->update([
                'title'=>$r->title,
                'description'=>$r->description
              ]);
      return redirect()->back()
                       ->with('type','success')
                       ->with('message', 'Edit successfully done');   
     }
     
     public function emailSupport(){
      $data['isMessage'] = true;
      return view('main.email-support',$data);
     }
     public function faqs(){
      $data['isMessage'] = true;
      return view('main.faqs',$data);
     }
     public function joinTeam(Request $r){
       $this->validate($r,[
        'board_id'=>'required',
       ]);


     }
     public function extendBookmarks(){
      $data['isMessage'] = true;
      $data['bookmarks'] = QuestionBookmark::where('user_id',Auth::id())->paginate(10);
      return view('main.extend-bookmarks',$data);
     }



}
