@extends('layouts.admin')
@section('content')
 <div id="maincontent" class="ui main container">
 	<div class="ui grid">
 		<div class="three wide column">
 			
 		</div>
 		<div class="ten wide column">
 			<div class="ui raised segment">
 				<a class="ui green ribbon label">View Test Question</a>
 				 <table class="ui celled table">
				  <thead>
				    <tr>
				      <th>ID</th>
				      <th>Name</th>
				      <th>Created At</th>
				  
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($questions as $q)
				  	<tr>
				  		<td>{{$q->id}}</td>
				  		<td>{{ucfirst($q->name)}}</td>
				  		<td>
				  			{{$q->created_at}}	
				  		</td>
				  		
				  	</tr>
				  	@endforeach
				  </tbody>
				</table>
				{{$questions->links()}}
 			</div>

 		</div>
 		<div class="three wide column">
 			
 		</div>
 	</div>
 	</div>
@endsection
@section('script')
 <script>
 	$('select.dropdown').dropdown();
 </script>
@endsection