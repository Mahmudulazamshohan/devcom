@extends('layouts.main')

@section('content')

   <div class="card-layout-1">
    <div style="display: flex;flex-direction: row;">
      <div style="flex-grow:5;display: flex;flex-direction: row;">
         
          <p id="question_show" >
            
            {{$question->title}}</p>

      </div>
    @php
          $imageLocation = null;
          if(!is_null($question->profile)){
            if(!is_null($question->profile->profile_image)){
            $imageLocation = explode('/',$question->profile->profile_image)[1];
            }else{

            }

          }
          
        @endphp
        @if(!is_null($question->profile))
           <a href="{{$question->profile->profile_image}}">
            <img src="{{route('view-image',[$imageLocation,100,100])}}" alt="" width="50" height="50" style="border-radius: 50%;border:2px solid #ccc;">
            <p style="text-align: center;word-break: break-all;">{{$question->user->name}}</p>
          </a>
        @else
           <img src="{{asset('images/user-blank.png')}}" id="showable_image" style="border-radius: 50%;border:2px solid #ccc;">
        @endif
     <div style="flex-grow:1;">
       
     </div> 
    </div>
   	 
   	<div class="ui divider"></div>
   	  <div style='font-family: Arial,"Helvetica Neue",Helvetica,sans-serif'>
        <?=$question->description?> 
      </div>
      @if($totalanswer == 0)
   	   <h2>No Answer</h2>
      @else
       <h2 style="font-family: 'Roboto';color: #555;">{{$totalanswer}} Answers</h2>
      @endif
   	  
   	  <div class="ui divider"></div>
   
      @foreach($answers as $answer)

         <div class="answer-areas">
           <div class="answer-vote">
             <div class="fa fa-3x fa-angle-up upangle"></div>
             <p>{{ $answer->totalvote() }}</p>
             <div class="fa fa-3x fa-angle-down downangle"></div>
             <input type="hidden" id="ans" value="{{$answer->id}}">
           </div>
           <div class="answer-description">
              <?=$answer->question_text?>
           </div>
          
         </div>
        <div class="user-area">
         <div class="user-flex">

          @if(!is_null($answer->profile))
           @php
           if(!is_null($answer->profile->profile_image)){
            $imageLocation= explode('/',$answer->profile->profile_image)[1];
            }
           @endphp
           <img src="{{route('view-image',[$imageLocation,100,100])}}" alt="" class="user-flex-img">
           @else
           <img src="{{asset('images/user-blank.png')}}" alt="" class="user-flex-img">
          @endif
           <div class="user-flex-name">
             <a href="">{{$answer->user->name}}</a>
             <p>answered {{\Carbon\Carbon::createFromTimeStamp(strtotime($answer->created_at))->diffForHumans()}}</p>
           </div>
         </div>
       </div>
        <div class="ui divider"></div>
      @endforeach
      @if(session()->has('type'))
      @if(session()->get('type') == 'danger')
      
      <div class="ui negative message">
        <i class="close icon"></i>
        <div class="header">
           {{session()->get('message')}}
        </div>
       </div>

      @endif
      @if(session()->get('type') == 'success')
      <div class="ui positive message">
        <i class="close icon"></i>
        <div class="header">
           {{session()->get('message')}}
        </div>
      </div>
      @endif
      @endif
      <h2 style="font-family: 'Roboto';color:#555;border-bottom:1px solid rgb(155, 191, 227);padding-bottom: 10px;">Your answer</h2>
   	  <div id="summernote">	
	    </div>
       

	    <form action="{{route('store-answer')}}" method="POST">
        @csrf
        <input type="hidden" name="question_id" value="{{$question->id}}">
        <input type="hidden" name="question_text" id="answer">

	    	<button class="ui primary submit labeled icon button mr-ten">
    
		      <i class="icon edit" style="color: #fff;"></i> Post Your Answer
		    </button>	  	 
   	  </form>
      <h4 >Not the answer you're looking for? Browse other questions tagged 
                 <div class="dflex-tags">
                   @foreach(explode(',', $question->tags) as $tag)
                     <a href="{{ route('tags',$tag) }}" class="btn-custom-tags">{{ ucfirst($tag) }}</a>
                   @endforeach
                 </div> 
                 
       </h4>
   </div>
@endsection
@section('script')
<script src="{{ asset('js/jquery-3.2.1.slim.min.js') }}" defer></script>
<script src="{{asset('js/jquery.min.js')}}" defer></script>
<script src="{{ asset('js/summernote-lite.js') }}" defer></script>

  <script type="text/javascript" defer>
    $('.close.icon').click(function() {
   $(this).parent().hide();
   
  });
    var isUpAngleHit = false;
    var isDownAngleHit = false;
    $('.upangle').click(function(event) {
       if(!isUpAngleHit){
         var values = Number($(this).parent().children('p').text());
         //var sum  = values += 1;
         var content = $(this); 
         var inputs = $(this).parent().children('input');
         
         $.ajax({
           url: '{{route('ajax_vote')}}',
           type: 'GET',
           dataType: 'json',
           data: {answer_id: inputs.val(),question_id:{{$id}}  },
         })
         .done(function(data) {
            console.log(data);
            if(!data.error){
              content.parent().children('p').text(values+data.count);
            }
         })
         .fail(function() {
           console.log("failed to fetch data");
         })
         .always(function() {
          
         });
         
         isUpAngleHit  = true;
       }else{
        alert('you already vote that');
       }
      
    });
     $('.downangle').click(function(event) {
     if(!isDownAngleHit){
         var values = Number($(this).parent().children('p').text());
         var content = $(this); 
         var inputs = $(this).parent().children('input');
         
          $.ajax({
           url: '{{route('ajax_vote_delete')}}',
           type: 'GET',
           dataType: 'json',
           data: {answer_id: inputs.val()},
         })
         .done(function(data) {
            if(!data.error){
              content.parent().children('p').text(values-data.count)
            }
         })
         .fail(function() {
           console.log("failed to fetch data");
         })
         .always(function() {
           console.log("complete");
         });
         isDownAngleHit  = true;
       }else{
        alert('you already vote that');
       }
    });
  	
 jQuery(document).ready(function(){
                $('#summernote').summernote({
                  placeholder: 'Write your question here.....',
                  tabsize: 2,
                  height: 220,
                  callbacks: {
                  onChange: function(contents, $editable) {
                  $("#answer").val(contents);

                  }
                  }
		      });         
     });

  </script>
@endsection