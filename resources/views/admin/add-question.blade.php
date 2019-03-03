@extends('layouts.admin')
@section('content')
 <div id="maincontent" class="ui main container">
 	<div class="ui grid">
 		<div class="three wide column">
 			
 		</div>
 		<div class="ten wide column">
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
			@if($errors->any())
			@foreach($errors->all() as $e)
			 <div class="ui negative message">
			  <i class="close icon"></i>
			  <div class="header">
			     {{$e}}
			  </div>
			 </div>
			@endforeach
			@endif
 			<div class="ui raised segment">
 				<a class="ui blue ribbon label">Add Test Question</a>
 				 <form class="ui form" action="{{route('admin.store-question')}}" method="POST">
 				 	@csrf
 				 	<div class="ui form">
					  <div class="field">
					    <label>Country</label>
					    <select class="ui search dropdown" name="question_category_id">
					    	@foreach($questions as $q)
					    	<option value="{{$q->id}}">{{ucfirst($q->name)}}</option>
					    	@endforeach
					    </select>
						</div>
					</div>
 
 				 	<div class="field">
					    <label>Question Title</label>
					    <input type="text" name="title" placeholder="Question Title">
					</div>
		
					<div class="ui form">
					  <div class="fields">
					    <div class="field">
					      <label>Option 1</label>
					      <input type="text" placeholder="Option 1" name="options[]">
					    </div>
					    <div class="field">
					      <label>Option 2</label>
					      <input type="text" placeholder="Option 2" name="options[]">
					    </div>
					    <div class="field">
					      <label>Option 3</label>
					      <input type="text" placeholder="Option 3" name="options[]">
					    </div>
					  </div>
					</div>
					
					<div class="field">
					    <label>Correct Option</label>
					    <input type="text" placeholder="Correct Option" name="correct">
					</div>
					<button class="ui blue button" type="submit">Submit</button>
 				 </form>
 			</div>
 		</div>
 		<div class="three wide column">
 			
 		</div>
 	</div>
 	</div>
@endsection
@section('script')
 <script>
 	$('.close.icon').click(function() {
   $(this).parent().hide();
   
  });
 	$('select.dropdown').dropdown();
 </script>
@endsection