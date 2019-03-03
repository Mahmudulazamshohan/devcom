@php
  use  Carbon\Carbon;
  
  function total_user($input){
    $input = number_format($input);
    $input_count = substr_count($input, ',');
    if($input_count != '0'){
        if($input_count == '1'){
            return substr($input, 0, -4).'k';
        } else if($input_count == '2'){
            return substr($input, 0, -8).'M';
        } else if($input_count == '3'){
            return substr($input, 0,  -12).'B';
        } else {
            return;
        }
    } else {
        return $input;
    }
}
@endphp
@extends('layouts.main')
@section('content')
    <div class="d-flex-1">
      <a href="{{route('home')}}" style="border-bottom: 2px solid rgb(58, 192, 255);">Recent Questions</a>
      <a href="{{route('most-answered')}}">Most Answered</a>
      <a href="{{route('most-visited')}}">Most Visited</a>
    </div>
 {{--  Content Started --}}
      <!-- Card End -->
      @foreach($questions as $question)
      <!-- Card Started -->
      
      <div class="card-layout">
        <div class="card-section-one">
          
          <div class="close-btn" data-tooltip="Hide this question" data-inverted=""  data-position="bottom center"><i class="fa fa-close"></i></div>
        </div>
        <div class="card-section-two">
           <div class="user">
             <img src="" alt="">
             <div class="details">
               <div class="details-name">
                 @if(!is_null($question->profile))
                   @php
                      $imageLocation = null;
                      if(!is_null($question->profile->profile_image)){
                        $imageLocation= explode('/',$question->profile->profile_image)[1];
                      }  
                   @endphp
                  <img src="{{ route('view-image',[$imageLocation,100,100]) }}" class="img-rounded w-10">
                  @else
                   <img src="{{ asset('images/user-blank.png') }}" class="img-rounded w-10">
                  @endif
                  <p>
                    {{ $question->user->name }}
                  </p>
               </div>
               <div class="details-date">
                  @php 
                    $carbon = \Carbon\Carbon::createFromTimeStamp(strtotime($question->created_at))->diffForHumans()
                  @endphp
                Answer at {{$carbon}}
               </div>
             </div>
           </div>
           <div class="question">
              <div class="flex-questions">
                  <div class="flex-questions-item">
                    <a href="{{route('view-question',$question->id)}}">{{$question->title}}@if(strlen($question->title)>=1000).......@endif</a>
                    <div class="tag-container">
                     @foreach(explode(',', $question->tags) as $tag)
                       <a href="{{ route('tags',$tag) }}" class="btn-custom-tags">{{ ucfirst($tag) }}</a> 
                     @endforeach
                    
                  </div>
                  </div>
                  <div class="flex-questions-item">
                     <div class="flex-col">
                       <div class="items">
                         <div class="circle-score">
                           {{total_user($question->totalViews())}}
                         </div>
                         <p >views</p>
                       </div>
                       <div class="items">
                         <div class="circle-score circle-green" >{{ total_user($question->totalAnswers())}}</div>
                          <p>answers</p>
                       </div>
                       <div class="items">
                         <div class="circle-score">
                           {{total_user($question->totalvotes())}}
                         </div>
                          <p>votes</p>
                       </div>
                     </div>
                  </div>
                 
              </div>
              
            
          </div>

          <div class="card-items">
            <a href="{{url('bookmark-add',$question->id)}}" style=""  data-tooltip="Save as bookmark" data-position="top left" 

              >
                <i class="bookmark icon" id="like-blue"></i>
              </a>
             <a href="{{route('view-question',$question->id)}}" style="margin-right: 70px;"  
             data-tooltip="Share this to friend" data-position="top left" class="share-btn">
                <i class="fa fa-share-alt" id="like-blue" ></i>
              </a>
              {{-- <a href="" data-tooltip="Like the post" data-position="top left">
                <i class="fa fa-thumbs-up" id="like-blue" ></i>100
              </a>
              <a href=""  data-tooltip="Total viewers" data-position="top left">
                  <i class="fa fa-eye" id="view-grey"></i>100
              </a>
              <a href=""  data-tooltip="Average Rating" data-position="top left">
                  <i class="fa fa-star" id="star-gold"></i>4.3
              </a> --}}
            </div>
        </div>
      </div>
      <!-- Card End -->
      @endforeach
     {{--  Content End --}}
     <div class="d-flex-link">
       <div>
        {{ $questions->links() }} 
       </div>
     </div>
  {{--  Modal  --}} 
   <div class="ui modal" id="model" style="width: 40%;">
  <i class="close icon" style="margin:35 !important; color:#555;"></i>
  <div class="header" style="color:#555;">
    <i class="fa fa-share-square-o"></i> Share Social Networks
  </div>
   <div style="padding: 30px;background: #eee;">
      <p style="font-family: arial;font-weight: 600;color:#1BBC9B;">Share This link</p>
      <div class="ui form">
        <input type="text" id="share-links" style="border:2px solid #555;font-weight: bold;">
      </div>
   </div>
   
   <div style="display: flex;flex-flow: row;justify-content: center;">
     <div class="social-btns" style="display: flex;flex-direction: row;padding: 10px 10px 40px 10px;">
       <div class="social-content">
         <a onclick="fbshareCurrentPage()" target="_blank" style="background: #4267B2;border-radius: 3px;padding: 4px;color:#fff;">
          <i class="fa fa-facebook" style="background: #fff;padding: 3px;border-radius:2px;color: #4267B2;"></i> Share</a>
       </div>
      
     </div>
   </div>
</div>
{{-- Modal --}}
<div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
@endsection
@section('script')

<script>
  var fb_share_url ="";
  $(document).ready(function(){
     $('.share-btn').click(function(e){
       e.preventDefault();
       $('#model').modal('show');
       var value = $(this).attr('href');
       fb_share_url = value;
       $("#set_share_fb").attr({href: value});
       $("#share-links").val(value);
       
     });
  });
   
    function fbshareCurrentPage()
    {
       console.log(fb_share_url);
      window.open("https://www.facebook.com/sharer/sharer.php?u="+escape(fb_share_url)+"&t="+document.title, '', 
    'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
    return false; }

    
    var closeButton = $('.close-btn');
    closeButton.click(function(){
      $(this).parent().parent().fadeOut('slow');
    }); 
    // var images =["https://images.pexels.com/photos/6224/hands-people-woman-working.jpg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940","https://images.pexels.com/photos/1011329/pexels-photo-1011329.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940"];
    // var c = 0;
    // setInterval(function(){
      
    //   if(images.length > c){
    //     $('.background_b').css({
    //     background: 'url('+images[c]+')'
    //   });
    //     c++;
    //   }else{
    //     c = 0;
    //   }
    // },10000);
</script>
@endsection