@extends('layouts.main')
@section('content')
   <div class="card-layout" style="border-bottom: none;">
   	<h1 style="color: #555;margin-top: 10px;padding: 10px;border-bottom: 1px solid #ccc;">Your notifications</h1>
   	  <div style="padding: 1.2em;">
   	  	@if(count($notifications) == 0)
   	  	  <h2 style="color: #555;margin-left: 30px;">You don't have any notification yet.</h2>
   	  	@endif
   	  	@foreach($notifications as $notification)
   	  	 <div class="ui grid border-bottom-one notification-body">
	   	  	<div class="one wide column">
	   	  		@php
					$imageLocation = null;
					if(!is_null($notification->profile)){
						if(!is_null($notification->profile->profile_image) && (strlen($notification->profile->profile_image) > 0)){
						$imageLocation= explode('/',$notification->profile->profile_image)[1];
						}

					}
					
				@endphp
				 @if(!is_null($notification->profile))
		     	     @if(strlen($notification->profile->profile_image) > 0)
			           <img src="{{route('view-image',[$imageLocation,100,100])}}" style="width: 30px;height: 30px;border-radius: 50%;">
			        @else
			           <img src="{{asset('images/user-blank.png')}}" style="width: 30px;height: 30px;border-radius: 50%;">
			        @endif
		     	  @else
		     	     <img src="{{asset('images/user-blank.png')}}" id="showable_image" style="width: 30px;height: 30px;border-radius: 50%;">
		     	  @endif
	   	  		
	   	  	</div>
	   	  	<div class="twelve wide column">
	   	  		{{$notification->notfication_string}}
	   	  	</div>
	   	  	<div class="three wide column">
	   	  		<div class="ui green basic button"><i class="fa fa-user-plus"></i> Join</div>
	   	  	</div>
	   	  </div>
	   	  @endforeach

	   	  

   	  </div>
   	  
   </div>
@endsection
