@php
  use  Carbon\Carbon;
  use App\Answer;
  use App\QuestionViews;
  use App\AnswerVote;
  
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
      <a href="{{route('home')}}">Recent Questions</a>
      <a href="{{route('most-answered')}}" >Most Answered</a>
      <a href="{{route('most-visited')}}" style="border-bottom: 2px solid rgb(58, 192, 255);">Most Visited</a>
    </div>
   <div class="card-layout">
      <h2 style="border-bottom: 1px dashed #ccc;padding-bottom: 10px;padding-left:30px;color: #555;font-family: 'Times New Roman';"><i class="fa fa-question-circle"></i> Most Visited Question </h2>
       @foreach($questions as $question)
      <!-- Card Started -->
      
      <div class="card-layout">
        <div class="card-section-one">
          
          <div class="close-btn" data-tooltip="Hide this question" data-inverted=""  data-position="bottom center"><i class="fa fa-close"></i></div>
        </div>
        <div class="card-section-two">
           <div class="user">
             <img src="" alt="">
             <div class="details">
               <div class="details-name">
                 @if(!is_null($question->profile_image))
                   @php
                      $imageLocation = null;
                      if(!is_null($question->profile_image)){
                        $imageLocation= explode('/',$question->profile_image)[1];
                      }  
                   @endphp
                  <img src="{{ route('view-image',[$imageLocation,100,100]) }}" class="img-rounded w-10">
                  @else
                   <img src="{{ asset('images/user-blank.png') }}" class="img-rounded w-10">
                  @endif
                  <p>
                    {{ $question->name }}
                  </p>
               </div>
               <div class="details-date">
                  @php 
                    $carbon = \Carbon\Carbon::createFromTimeStamp(strtotime($question->created_at))->diffForHumans()
                  @endphp
                Answer at {{$carbon}}
               </div>
             </div>
           </div>
           <div class="question">
              <div class="flex-questions">
                  <div class="flex-questions-item">
                    <a href="{{route('view-question',$question->question_id)}}">{{substr($question->title,0,100)}}@if(strlen($question->title)>=100).......@endif</a>
                    <div class="tag-container">
                     @foreach(explode(',', $question->tags) as $tag)
                         <a href="{{ route('tags',$tag) }}" class="btn-custom-tags">{{ ucfirst($tag) }}</a>
                     @endforeach
                   
                  </div>
                  </div>
                  <div class="flex-questions-item">
                     <div class="flex-col">
                       <div class="items">
                         <div class="circle-score">
                           {{total_user(totalViews($question->question_id))}}
                         </div>
                         <p >views</p>
                       </div>
                       <div class="items">
                         <div class="circle-score circle-green" >{{ total_user(totalAnswers($question->question_id))}}</div>
                          <p>answers</p>
                       </div>
                       <div class="items">
                         <div class="circle-score">
                           {{total_user(totalvotes($question->question_id))}}
                         </div>
                          <p>votes</p>
                       </div>
                     </div>
                  </div>
                 
              </div>
              
            
          </div>

          <div class="card-items">
            <a href="{{url('bookmark-add',$question->question_id)}}" style=""  data-tooltip="Save as bookmark" data-position="top left" 

              >
                <i class="bookmark icon" id="like-blue"></i>
              </a>
             <a href="{{route('view-question',$question->question_id)}}" style="margin-right: 70px;"  
             data-tooltip="Share this to friend" data-position="top left" class="share-btn">
                <i class="fa fa-share-alt" id="like-blue" ></i>
              </a>
              
            </div>
        </div>
      </div>
      <!-- Card End -->
      @endforeach
     {{--  Content End --}}
   </div>

@endsection
