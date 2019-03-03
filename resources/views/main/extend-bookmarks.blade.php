@php
  use  Carbon\Carbon;
  use App\Answer;
  use App\QuestionViews;
  use App\AnswerVote;
  use App\QuestionBookmark;
 
  
  function total_user($input){
    $input = number_format($input);
    $input_count = substr_count($input, ',');
    if($input_count != '0'){
        if($input_count == '1'){
            return substr($input, 0, -4).'k';
        } else if($input_count == '2'){
            return substr($input, 0, -8).'M';
        } else if($input_count == '3'){
            return substr($input, 0,  -12).'B';
        } else {
            return;
        }
    } else {
        return $input;
    }

  }
   function totalAnswers($id){
     return Answer::where('question_id',$id)->count();
   }
   function totalViews($id){
     return QuestionViews::where('question_id',$id)->count();
   }
   function totalvotes($id){
    return AnswerVote::where('question_id',$id)->count();
   }


@endphp
@extends('layouts.main')
@section('content')
   <div class="d-flex-1">
      <h3 style="padding:10px;font-family: 'Roboto';color: #555;">
        Saved Questions
      </h3>

    </div>
   <div class="card-layout" style="border:none;padding: 37px;">
      <div class="ui grid">
        @foreach($bookmarks as $bookmark)
        <div class="fourteen wide column ls-br">
          
          <div class="feed-items" style="display: flex;flex-direction: row;">
            @if($tag = explode(',',$bookmark->question->tags)[0])
          
             @if(file_exists(public_path('icons/'.$tag.'.png')))
               <img src="{{asset('icons/'.$tag.'.png')}}" style="width: 30px;height: 30px;">
             @else
               <img src="{{ asset('icons/images.jpg') }}" style="width: 30px;height: 30px;">
             @endif
             
            @else
              <img src="https://i.stack.imgur.com/ez2Mg.png">
            @endif
            
            <div >
              <a style="margin-top: 10px;margin-left: 4px;" href="{{route('view-question',$bookmark->question->id)}}">{{$bookmark->question->title}}</a>
              <p style="display: flex;flex-direction: row;">    <p style="color: #555;"> {{$bookmark->question->user->name}} </p> 
             
              </p>
            </div>
          </div>
         
        </div>
         
        <div class="two wide column">
          <button class="ui button default">
            <i class="fa fa-eye"></i>views
            {{total_user($bookmark->question->totalViews())}}
          </button>
        </div>
         @endforeach
      </div>
      <div style="margin:10px auto 0 auto;">
        {{$bookmarks->links()}}
      </div>
    </div>

@endsection
