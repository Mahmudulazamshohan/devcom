@extends('layouts.main')
@section('content')
   <div class="card-layout-1">
      <h1>Tags</h1>
      <div class="tag-search">
         <form action="" method="GET">
           <div class="ui form">
            <input type="text" name="q">
           </div>
          <button 
            class="ui button primary" 
            style="margin-left: 10px;"
            type="submit" 
            ><i class="fa fa-search"></i>
           </button> 
         </form>
         

      </div>
   	<div class="ui grid">
        <div class="four column row">
            @foreach($tags as $tag)
             <div class="column">
            
               <div class="tags-area">
                  <div class="tags-area-p">
                     <a href="{{route('tags',$tag['name'])}}">{{strtolower($tag['name'])}}</a>
                     <p> x {{$tag['count']}}</p>
                  </div>
               </div>
              
             </div>
           @endforeach
         
        </div>  
      </div>
   </div>

@endsection