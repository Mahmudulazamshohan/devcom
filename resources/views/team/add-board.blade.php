@extends('layouts.team')
@section('content')

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
 <form action="{{route('team.store-board')}}" method="POST">
 	@csrf
 	<div class="ui form">
	  <div class="inline fields">
	    <div class="eight wide field {{$errors->has('title') ? 'error': '' }}">
	      <label>Title</label>
	      <input type="text" placeholder="Enter Your Board Title" name="title">
			@if ($errors->has('title'))
			    <span class="invalid-feedback" role="alert" style="padding: 10px; color:red;">
			        <strong>{{ $errors->first('title') }}</strong>
			    </span>
			@endif
			
			
	    </div>
	    <div class="three wide field">
	      <button class="ui button primary">Create Board</button>
	    </div>
	   
	  </div>
	</div>
 </form>
@endsection
@section('script')
<script type="text/javascript">
  $('.close.icon').click(function() {
	 $(this).parent().hide();
	 
	});
</script>
@endsection