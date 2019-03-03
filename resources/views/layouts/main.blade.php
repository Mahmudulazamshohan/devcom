@php
  use App\QuestionBookmark;
  use App\Notification;
  use App\ContentInterested;
  use App\Question;


  $bookmarks = null;
  if(Auth::check()){
  $bookmarks = QuestionBookmark::where('user_id',Auth::id())->limit(5)
     ->orderBy('id','desc')
     ->get();  
  }
  

  if(Auth::check()){
    $total = Notification::where('user_id',Auth::id())
                         ->where('view_status',0)
                         ->count(); 
  }
  $hotNetworks = null;
  $contentInterested  =null;
  if(Auth::check()){
    $technos = [];
    

    //Object
    $contentInterested = ContentInterested::where('user_id',Auth::id())->first();

    if($contentInterested){
      $technos = explode(',',$contentInterested->question_categories_as_text);
      $hotNetworks = Question::where('tags','like',"%$technos[0]%");

      foreach ($technos as $t) {
         $hotNetworks->orWhere('tags','like',"%$t%");
      }
       $hotNetworks = $hotNetworks->inRandomOrder()->get();


    }
  }

  if(is_null($hotNetworks)){
    $hotNetworks = Question::inRandomOrder()->limit(10)->get();
  }
    //dd($hotNetworks);

  
@endphp
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
 {{--  Facebook --}}
  <meta property="og:url"           content="https://127.0.0.1/abc.html" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Your Website Title" />
  <meta property="og:description"   content="Your description" />
  <meta property="og:image"         content="https://www.your-domain.com/path/image.jpg" />
  {{--  Facebook --}}

  <title>DevCom | Community system for developers</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" type="text/css" href="{{ asset('styles/bundle.css') }}">
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/components/icon.min.css'>
  <link href="https://fonts.googleapis.com/css?family=Quattrocento|Ceviche+One|Lakki+Reddy|Merienda|Shrikhand|Roboto|Josefin+Sans|Unlock" rel="stylesheet">
 
  <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet">
  <style type="text/css">
    .bell,.trophy{
      transition: transform 2s;
    }
    #notification:hover > .bell{
      transform: rotate(45deg);
    }
    #achievements:hover > .trophy{
      transform: rotate(45deg);
    }
  </style>



</head>

<body>
  <nav>
    <div class="ui top fixed secondary menu">
      <a class="item">
       <div class="icon">DevCom</div>
    </a>
    <a class="active item" href="{{route('home')}}">
      Home
    </a>
    

    <a class="item" id="achievements" href="{{route('achievements')}}">
      <i class="trophy icon"></i>  Achievements
    </a>

    <a class="item" href="{{route('team.home')}}">
       <i class="fa fa-users" style="color: #555;margin-right:4px;"></i> Teams
    </a>
   
  <a class="item" id="notification" data-html="<h1>a</h1>"
    href="{{route('notifications')}}">

    <i class="bell icon"></i> 
    @auth
    <div class="floating ui green label" style="margin-top: 8px !important;">{{$total}}</div>
    @endauth
     Notification
  </a>
  <a class="item" href="{{ route('add-question') }}">
    <button class="ui inverted primary button">{{ __('Ask Question') }}</button>
  </a>
  <div class="right menu">
    <div class="item">
      <div class="ui search">
        <div class="ui icon input">
          <input class="prompt" type="text" placeholder="Search..."  style="width: 300px!important;">
          <i class="search icon"></i>
        </div>
        <div class="results"></div>
      </div>
    </div>
  </div>

  <div class="right menu" style="margin-right: 20px;">
    @auth

      <a href="{{ route('profile') }}" class="ui item" style="color:#555;">
        <i class="fa fa-user" ></i>&nbsp;{{Auth::user()->name }}
      </a>
      <a href="{{ route('profile') }}" class="ui item" style="color:#555;" 
          onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out" ></i>&nbsp;Logout
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
    @else
     
      <a href="{{ route('login') }}" class="ui item" style="color:#555;">
        <i class="fa fa-sign-in"></i>&nbsp;{{ __('Login
')}}      </a>
      <a href="{{ route('register') }}" class="ui item" style="margin: 0;">
        {{ __('Signup')}}
      </a>
    @endauth
  </div>
</div>
  </nav>
  @if($isMessage)
<div class="background_b mr-ten">
  <div class="bg_item">
    <div class="center_item">
          <h1>Share & grow the world's knowledge!</h1>
          <p>We want to connect the people who have knowledge to the people who need it, to bring together people with different perspectives so they can understand each other better, and to empower everyone to share their knowledge</p>
    </div>

  </div>
  
   <div class="bg_item">
     <div class="align-btn">
      @guest
       <a href="{{route('register')}}" class="ui primary button" style="background: #3AC0FF;margin-left: 230px;padding: 12px;">
         Create A New Account
       </a>
       @endguest
     </div>
    
   </div>

</div>
 @endif

<div class="content @if(!$isMessage) mr-ten @endif" >
  <div class="grid grid-col-4 grid-space-3">
    <div class="item1">
      <div class="sidebox">
        <div class="ui vertical menu" style="background: #eee !important;border:none;">
  <div class="item">
    <div class="header">Menu</div>
    <div class="menu">
      <a class="item" href="{{route('my-questions')}}"><i class="fa fa-question-circle"></i> Questions</a>
      <a class="item" href="{{route('my-answers')}}">
        <i class="fa fa-reply"></i> Answers
      </a>
    </div>
  </div>
  <div class="item">
    <div class="header">Community</div>
    <div class="menu">
      <a class="item" href="{{route('tagsshow')}}"><i class="fa fa-tag"></i> Tags</a>
     {{--  <a class="item" href="{{route('users')}}"><i class="fa fa-user"></i> Users</a>
      <a class="item" href="{{route('top-users')}}"><i class="fa fa-star"></i> Top</a> --}}
    </div>
  </div>
  
  <div class="item">
    <div class="header">Support</div>
    <div class="menu">
      <a class="item" href="{{route('email-support')}}">E-mail Support</a>
      <a class="item" href="{{route('faqs')}}">FAQs</a>
    </div>
  </div>
  @auth
  <div class="item">
     <a class="ui inverted button green " href="{{ route('test-question-category') }}"> <i class="fa fa-2x fa-question-circle" style="color:green"></i>&nbsp;Take A Test</a>
  </div>
  @endauth
</div>
      </div>
    </div>
    <div class="item2">
      @yield('content')
    </div>
    <div class="item3" id="it3">
      <p class="feed-text">Feed Stories</p>
      <p class="book-marked">Bookmarked Answers</p>
      <div class="feed-categories">
        @if($bookmarks)
          @foreach($bookmarks as $bookmark)
          <div class="feed-items">
            @if($tag = explode(',',$bookmark->question->tags)[0])
          
             @if(file_exists(public_path('icons/'.$tag.'.png')))
               <img src="{{asset('icons/'.$tag.'.png')}}">
             @else
               <img src="{{ asset('icons/images.jpg') }}">
             @endif
             
            @else
              <img src="https://i.stack.imgur.com/ez2Mg.png">
            @endif
            
            <a href="{{route('view-question',$bookmark->question->id)}}"><p>{{substr($bookmark->question->title,0,30)}}...</p></a>
          </div>
          @endforeach
        @else
         <h5 style="text-align: center;color:#fff;font-family: 'Roboto';background: #444;border-radius: 5px; ">Not Found</h5>
        @endif
        @if(!is_null($bookmarks))
        <a href="{{route('extend-bookmarks')}}" style="background: rgb(58, 192, 255);padding:0px 4px 0px 4px ;border-radius: 3px;
        width:40px;color: #fff;margin-top:5px;margin-left:5px;">more</a>
        @endif

      </div>
      <p class="net-text">Hot Network Question</p>
      <div class="network-categories">
        @foreach($hotNetworks as $h)
        <div class="network-items">
          
          
           
           @if($t = explode(',',$h->tags)[0])
          
             @if(file_exists(public_path('icons/'.$t.'.png')))
               <img src="{{asset('icons/'.$t.'.png')}}">
             @else
               <img src="{{ asset('icons/images.jpg') }}">
             @endif
             
            @else
              <img src="https://i.stack.imgur.com/ez2Mg.png">
            @endif
            <a href="">{{$h->title}}</a>
          
          
        </div>
        @endforeach
      </div>
      <div>
        
        @auth
        <p class="watch-text">
          <i class="fa fa-eye"></i> Watched Tags
        </p>
        <select multiple="" class="ui search fluid dropdown">
        @if(!is_null($contentInterested))
          @foreach(explode(',',$contentInterested->question_categories_as_text) as $ci)
          <option selected>{{ucfirst($ci)}}</option>
          @endforeach
        @endif
        </select>
        @else
         
        @endauth
      </div>
    </div>
   
  </div>
</div>
<footer class="footer">
  <div class="grid grid-col-4 grid-space-3">
    <div class="items">
      <div class="ui list" style="padding: 10px !important;">
        <div class="item">
          <ul>
            <li><h1 class="first-child">{{env('APP_NAME')}}</h1></li>
            <li>Questions</li>
            <li>Jobs</li>
            <li>Helps</li>
          </ul>
        </div>
        
      
      </div>
    </div>
    <div class="items">
     <div class="ui list" style="padding: 10px !important;margin-top:10px;">
        <div class="item">
          <ul>

             <li >
              <a href="{{route('team.home')}}" style="color: white;">Teams</a>
            </li>
            <li >
              <a href="{{route('notifications')}}" style="color: white;margin-left: 4px;">Notifications</a>
            </li>
            <li >
              <a href="{{route('achievements')}}" style="color: white;margin-left: 4px;">Achievements</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="items">
      <div class="ui list" style="padding: 10px !important;margin-top:10px;">
        <div class="item">
          <ul>
            <li >
              <a href="" style="color: white;">Links</a>
            </li>
            <li >
              <a href="" style="color: white;">Facebook</a>
            </li>
            <li >
              <a href="" style="color: white;">Google Plus</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="items">
      <div class="ui list" style="padding: 10px !important;margin-top:10px;">
        <div class="item">
          
        </div>
      </div>
    </div>
  </div> 
</footer>

</body>
 <!--- Component JS -->
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/iframe-content.js') }}"></script>
  <script type="text/javascript" src="{{asset('js/all.js') }}"></script>
@yield('script')
<script type="text/javascript">

 $('.ui.search')
  .search({
    minCharacters : 1,
    apiSettings: {
      url: '{{route('api.search')}}?q={query}',
      onResponse: function(githubResponse) {
        //console.log(githubResponse);
        var response = {
            results : []
          };
          $.each(githubResponse,function(index, el) {
            el.forEach((r)=>{
              response.results.push({
                title       : r.name,
                description:r.description,
                url         : r.html_url
                });
            });
            
          });
          
        return response;
      }
    }});

  $('.ui.dropdown').dropdown({
    allowAdditions: true,
     onChange: function(value, text, $selectedItem) {
           $('#original_tags').val(value);
    }
  });
</script>

</html>