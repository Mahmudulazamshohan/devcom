@extends('layouts.main')
@section('content')
 {{--  Content Started --}}
 <div class="card-layout-1">
 	<div class="ui grid">
 		<div class="sixteen wide column">
 			@foreach($answers as $a)
 			<div class="ui raised segment">
		      <a href="{{route('view-question',$a->question_id)}}" class="ui green ribbon label">
		      	<i class="fa fa-question-circle"> {{substr($a->question->title, 0,130)}} </i>
		      </a>
		      <div>
		       <?=$a->question_text?>
		      </div>
		      <div class="ui grid">
		      	<div class="eight wide column">
		      		<div class="ui link items">
		      	<div class="item">
				    <div class="ui tiny image">
				      @if(!is_null($a->question->profile))
			           @php
			           if(!is_null($a->question->profile->profile_image)){
			            $imageLocation= explode('/',$a->question->profile->profile_image)[1];
			            }
			           @endphp
			           <img src="{{route('view-image',[$imageLocation,100,100])}}" alt="" >
			          @else
			           <img src="{{asset('images/user-blank.png')}}" alt="" class="user-flex-img">
			          @endif
				    </div>
				    <div class="content">
				      <a href="" class="header">{{$a->question->user->name}}</a>
				      <div class="description">
				        <p></p>
				      </div>
				    </div>
				  </div>
		      </div>
		      	</div>
		      	<div class="eight wide column">
		      		<div class="ui buttons">
					   <button class="ui  button">
					  	 <i class="fa fa-eye"></i>{{$a->question->totalViews()}}
					   </button>
					  <div class="or"></div>
					  <button class="ui button">
					  	<i class="fa fa-thumbs-up"></i>
					  	{{$a->totalvote()}}
					  </button>
					</div>
		      	</div>
		      </div>
		      

		    </div>
 			
 			@endforeach
 			<div>
 				{{$answers->links()}}
 			</div>
 		</div>
 	</div>
 </div>
@endsection