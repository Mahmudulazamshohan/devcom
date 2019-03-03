@php 
use  Carbon\Carbon;

@endphp
@extends('layouts.team')
@section('content') 
<div style="max-width: 910px;">
	<div class="ui grid">
	  @foreach($members as $m)
	  <div class="four wide column">

	  	<div class="ui card">
			  <div class="image">
			  	@php
          $imageLocation = null;
          if(!is_null($m->profile)){
            if(!is_null($m->profile->profile_image)){
            $imageLocation = explode('/',$m->profile->profile_image)[1];
            }else{

            }

          }
          
        @endphp
        @if(!is_null($m->profile))
       
            <img src="{{route('view-image',[$imageLocation,500,500])}}" alt="">
        
        @else
           <img src="{{asset('images/user-blank.png')}}" >
        @endif
			   {{--  <img src="https://semantic-ui.com/images/avatar2/large/kristy.png"> --}}
			  </div>
			  <div class="content">
			    <a class="header">{{$m->user->name}}</a>
			    <div class="meta">
			     @php
			      $date= Carbon::parse($m->created_at);
			     @endphp
			      <span class="date">Joined in {{$date->format('Y')}}</span>
			    </div>
			    
			  </div>
			  
			</div>
			
	  </div>
	  @endforeach
	</div>
</div>
<style type="text/css">
	.flex-sidebar{
		width: 20%;
	}
</style>

@endsection