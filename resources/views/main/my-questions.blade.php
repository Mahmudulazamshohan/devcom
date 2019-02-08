@php
  use  Carbon\Carbon;
  
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
@endphp

@extends('layouts.main')
@section('content')
 {{--  Content Started --}}
   <div class="card-layout-1">
   	<h1 style="color:#555;padding-bottom: 10px;border-bottom:1px solid #ccc;">You Added These Questions</h1>
   	@foreach($questions as $question)
   	<div class="card-questions" style="background:#eee;border-radius: 4px ;padding: 15px;margin-bottom:4px;">
   		<div class="ui grid">
   	      <div class="eleven wide column">
   	      	<div style="width: 100%;display: flex;flex-direction: row;">
   	      		 <h5 style="flex-grow:7;">{{substr($question->title, 0,30)}}.....</h5>
   	      		 <div style="flex-grow:3;display: flex;flex-direction: row;">
   	      		  <button class="ui circular linkedin icon button">
					  <i class="question circle icon" style="color: #fff;"></i>{{ total_user($question->totalAnswers())}}
					</button>
					<button class="ui circular linkedin icon button">
					  <i class="bullseye icon" style="color: #fff;"></i>{{total_user($question->totalViews())}}
					</button>
					<button class="ui circular linkedin icon button">
					  <i class="thumbs up icon" style="color: #fff;"></i>{{ total_user($question->totalvotes())}}
					</button>
   	      		 </div>
   	      	</div>
   	      	
   	      </div>
		  <div class="three wide column">
		  	<div style="display: flex;flex-direction: row;">
		  		<a href="{{route('edit-question',$question->id)}}" class="ui button mini primary">
		  			<i class="fa fa-pencil"></i>
		  			Edit
		  		</a>
		  		 <a href="" class="ui mini inverted red button">
		  			<i class="fa fa-pencil"></i>
		  			Delete
		  		 </a>
           <a href="{{route('view-question',$question->id)}}" class="ui mini primary button">
            <i class="fa fa-chevron-right" style="margin-top: 6px;"></i>
    
           </a>
		  	</div>
		  </div>
		</div>
   	</div>
   	@endforeach
    <div>
      <div style="float: right;">
           {{ $questions->links()}}
      </div>
    
    </div>
   </div>
@endsection