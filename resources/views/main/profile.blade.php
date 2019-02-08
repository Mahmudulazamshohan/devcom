@extends('layouts.main')
@section('content')
 {{--  Content Started --}}
   <div class="card-layout-2">

   	<h2 class="ui icon header">
  <i class="user  icon" style="border:2px solid #000;width:85px;height:85px;border-radius: 50%;color: #555;"></i>
  <div class="content" style="line-height: .8em;margin-top: -1px;">
    Profile Settings
    <div class="sub header">Manage your account settings and set e-mail preferences.</div>
  </div>
</h2>
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
   	  <form class="ui form" action="{{route('store-profile')}}" method="POST"  enctype="multipart/form-data" >
   	  	@csrf
     <div class="dflex">
				@php
					$imageLocation = null;
					if(!is_null($profile)){
						if(!is_null($profile->profile_image) && (strlen($profile->profile_image) > 0)){
						$imageLocation= explode('/',$profile->profile_image)[1];
						}

					}
					
				@endphp
     	  @if(!is_null($profile))
     	     @if(strlen($profile->profile_image) > 0)
	           <img src="{{route('view-image',[$imageLocation,100,100])}}" style="width: 30px;height: 30px;border-radius: 50%;">
	        @else
	           <img src="{{asset('images/user-blank.png')}}" style="width: 30px;height: 30px;border-radius: 50%;">
	        @endif
     	  @else
     	     <img src="{{asset('images/user-blank.png')}}" id="showable_image">
     	  @endif
	  <div class="field" style="margin-left: 20px;">
	  	   <label>Upload Profile Picture</label>
	       <input type="file" name="image" >
	  </div>
     </div>
     
   	 <div class="field">
   	 	
	    <label>Name</label>
	    @if(!is_null($profile))
	    <input type="text" name="name" placeholder="Profile username" value="{{$profile->user->name}}">
	    @else
	      <input type="text" name="name" placeholder="Profile username" value="">

	    @endif
	  </div>
	  <div class="field">
	    <label>Email</label>
	      @if(!is_null($profile))
	    <input type="text" name="email" placeholder="Profile username" value="{{$profile->user->email}}">
	    @else
	      <input type="text" name="email" placeholder="Profile username" value="">

	    @endif
	  </div>
	  <div class="field">
	    <label>Education</label>
	    @if(!is_null($profile))
	    <input type="text" name="education" placeholder="" value="{{$profile->education}}">
	    @else
	      <input type="text" name="education" placeholder= value="">

	    @endif	  </div>
	  <div class="field">
	    <label>Employment</label>
	    @if(!is_null($profile))
	    <input type="text" name="employment" placeholder="" value="{{$profile->employment}}">
	    @else
	      <input type="text" name="employment" placeholder="" value="">

	    @endif
	  </div>
	  <div class="field">
	    <label>Location</label>
	    @if(!is_null($profile))
	    <input type="text" name="location" placeholder="" value="{{$profile->location}}">
	    @else
	      <input type="text" name="location" placeholder="Location" value="">

	    @endif	  </div>
	  
	  
	  <button class="ui violet button" type="submit">Update</button>
	</form>
   </div>
 {{--  Content End --}}
@endsection
@section('script')
<script type="text/javascript">
  $('.close.icon').click(function() {
	 $(this).parent().hide();
	 
	});
</script>
@endsection

