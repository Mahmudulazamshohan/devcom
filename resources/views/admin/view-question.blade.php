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
				      <th>Category</th>
				      <th>Title</th>
	
				      <th>Correct</th>
				      <th>Wrong</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($questions as $q)
				  	<tr>
				  		<td>{{$q->questionCategories->name}}</td>
				  		<td>{{$q->question_string}}</td>
				  		<td>
				  			<ul>
				  				<li>{{$q->correct}}</li>
				  			</ul>	
				  		</td>
				  		<td>
				  			<ul>
				  				@foreach(explode(',',$q->wrong) as $s)
				  				   <li>{{$s}}</li>
				  				@endforeach
				  			</ul>
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