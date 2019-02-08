@extends('layouts.main')
@section('content')
 {{--  Content Started --}}
   <div class="card-layout-1">
   	       <h1 style="color: #555;border-bottom: 1px dashed #ccc;padding-bottom: 10px;">Ask Question below this form</h1>
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
   	  <form class="ui form" action="{{route('store-question')}}" method="POST">
   	  	@csrf
	  <div class="field">
	    <label>Title</label>
	    <input type="text" name="title" placeholder="Question Title">
	     @if($errors->has('title'))
	      <p></p>
	     @endif
	  </div>
	  <div class="field">
	    <label>Description</label>
	    
	    <div id="summernote">
	    	
	    </div>
	    <input placeholder="Write Your Question here" name="description" id="editor" type="hidden" >
	  </div>
	  <div class="field">

  </script>
	    <label>Tags</label>
	    <select multiple="" class="ui search fluid dropdown">
	      @foreach($question_categories as $question_categorie)
		  <option value="{{$question_categorie->name}}">{{ucfirst($question_categorie->name)}}</option>
		  @endforeach
		</select>
		<input type="hidden" name="tags" id="original_tags">
	  </div>
	  
	  <button class="ui violet button" type="submit">Submit</button>
	</form>
   </div>
 {{--  Content End --}}
@endsection

@section('script')
<script type="text/javascript">
  	$('.ui.dropdown').dropdown({
	  allowAdditions: true,
	   onChange: function(value, text, $selectedItem) {
		       $('#original_tags').val(value);
		}
	});
	$('.close.icon').click(function() {
	 $(this).parent().hide();
	 
	});
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.js" defer></script>

  <script type="text/javascript" defer>
  	
 jQuery(document).ready(function(){
                $('#summernote').summernote({
		        placeholder: 'Write your question here.....',
			    tabsize: 2,
		        height: 250,
		        callbacks: {
				    onChange: function(contents, $editable) {
				     $("#editor").val(contents);

				    }
				  }
		      });         
     });

  </script>

  
@endsection

