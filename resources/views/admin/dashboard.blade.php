@extends('layouts.admin')
@section('content')
 <div id="maincontent" class="ui main container">
  <!--<h1 class="ui header">Hjem</h1>-->
  <div class="ui stackable grid">
    <div class="nine wide column">
    	
		    <div class="ui raised segment">
		      <a class="ui olive ribbon label">Overview</a>
		      <span>Last Details</span>
		      <table class="ui celled table">
				  <thead>
				    <tr>
				      <th>User ID</th>
				      <th>Name</th>
				      <th>Email</th>
				      <th>Join At</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($users as $u)
				    <tr>
				      <td>{{$u->id}}</td>
				      <td>{{$u->name}}</td>
				      <td>{{$u->email}}</td>
				       <td>{{$u->created_at}}</td>
				   </tr>
				   @endforeach
				  
				    
				  </tbody>
				</table>
	
				<div>
					{{$users->links()}}
				</div>
		
		    </div>

		    <div class="ui segment">
					a
			</div>
 
     </div> 
     <div class="six wide column">
     	
     	<div class="ui segment">
     		<div class="ui compact menu">
			  <a class="item">
			    <i class="icon users"></i> Total users
			    <div class="floating ui green label">
			      {{$total}}
			    </div>
			  </a>
			  
			</div>
     	</div>
     	 <div class="ui raised segment">
     	 	<a class="ui blue ribbon label">Community</a> User Questions
		      <table class="ui celled table">
				  <thead>
				    <tr>
				      <th>Title</th>
				      <th>Tags</th>
				      <th>Created At</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($questions as $p)
				    <tr>
				      <td>{{$p->title}}</td>
				      <td style="word-break: break-all;">{{substr($p->tags,0,100)}}</td>
				       <td>{{$p->created_at}}</td>
				   </tr>
				   @endforeach
				  
				    
				  </tbody>
				</table>
     	 </div>
     </div>
  </div>
</div>
@endsection