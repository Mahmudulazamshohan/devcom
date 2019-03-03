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
 				<a class="ui blue ribbon label">Add Category</a>
 				 <form class="ui form" action="{{route('admin.store-question-category')}}" method="POST">
 				 	@csrf
 				 	
 				 	<div class="field">
					    <label>Name</label>
					    <input type="text" name="name" placeholder="Technology Name">
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