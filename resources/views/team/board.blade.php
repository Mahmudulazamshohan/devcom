
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="csrf-token" content="{{csrf_token() }}">
 
  <title>DevCom | Community system for developers</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" type="text/css" href="{{ asset('styles/bundle.css') }}">
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/components/icon.min.css'>
  <link href="https://fonts.googleapis.com/css?family=Quattrocento|Ceviche+One|Lakki+Reddy|Merienda|Shrikhand|Roboto|Josefin+Sans|Unlock" rel="stylesheet">
 
  <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet">
<script type="text/javascript">
            window.Laravel = {csrf_token:'{{csrf_token()}}'};
</script>


</head>

<body>
  <nav>
    <div class="ui top fixed secondary menu">

    <a class="active item" href="{{route('home')}}">
      Home
    </a>
     
    <a class="item" id="board-slide" href="{{route('team.home')}}">
     <i class="clipboard icon"></i>  Team Home
    </a>
   
  <a class="item" id="notification" data-html="<h1>a</h1>">
    <i class="bell icon"></i> Notification
    <div class="floating ui green label" style="margin-top: 8px !important;">1</div>
 
  </a>
 
 <div class="center menu" style="margin:0 auto 0 auto;">
 	 <a class="item" href="{{route('home')}}">
       <div class="icon" style="color: #CCE1ED;">
         <i class="columns icon" style="color: #CCE1ED;"></i>DevCom
        </div>
       </a>
 </div>
  <div class="right menu" style="margin-right: 20px;">
  	
    @php
       use App\Profile;
        $profile = Profile::where('user_id',Auth::id())->first();
        $imageLocation = null;
        if(!is_null($profile)){
          if(!is_null($profile->profile_image) && strlen($profile->profile_image)){
          $imageLocation= explode('/',$profile->profile_image)[1];
          }

        }
    @endphp
        
    <a href="" class="ui item">
     
      @if(!is_null($profile))
        @if(strlen($profile->profile_image) > 0)
           <img src="{{route('view-image',[$imageLocation,100,100])}}" style="width: 30px;height: 30px;border-radius: 50%;">
        @else
           <img src="{{asset('images/user-blank.png')}}" style="width: 30px;height: 30px;border-radius: 50%;">
        @endif
      @else
         <img src="{{asset('images/user-blank.png')}}" style="width: 30px;height: 30px;border-radius: 50%;">
      @endif
    </a>
  </div>
</div>
  </nav>
  <div id="app">
    <kanbanboard title="{{$id}}" board_name="{{$name}}"></kanbanboard>
  </div>
  

  </body>
   <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/iframe-content.js') }}"></script>
  <script type="text/javascript" src="{{asset('js/all.js') }}"></script>
  <script src="{{asset('js/app.js')}}"></script>
  
  {{-- <script src="{{asset('js/code.min.js')}}"></script>
   --}}
</html>