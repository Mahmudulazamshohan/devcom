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
  <style type="text/css">
  	body {
  height: calc(100% - 7em) !important;
  background: lighten(#FAFDF0,1);
}


.dont-show {
  display: none;
}

#userbutton {
  font-size: .88em;

  i {
    font-size: 1rem;
  }
  
}

#maincontent {
    margin-top: 7em;
    margin-bottom: -7em;
  .ribbon {
    margin-bottom: 1.3em;
    cursor: default;
  }
  
  }

  </style>
  


</head>

<body>
	<div class="ui fixed  menu">
  <div class="ui container">
    <a href="{{route('home')}}" class="header item">
      <i class="bar chart icon"></i>
      {{__('DevCom Admin')}}

    </a>
    <a href="{{route('admin.dashboard')}}" class="active item">Home</a>

    <div class="ui simple dropdown item">
      Questions <i class="dropdown icon"></i>
      <div class="menu">
        <a class="item" href="{{route('admin.add-question')}}">Add Questions</a>
        <a class="item" href="{{route('admin.view-question')}}">View Questions</a>
        
      </div>
    </div>

    <div class="ui simple dropdown item">
      Question Category <i class="dropdown icon"></i>
      <div class="menu">
        <a class="item" href="{{route('admin.add-question-category')}}">Add</a>
        <div class="divider"></div>
        <a class="item" href="{{route('admin.question-category-view')}}">View</a>
      </div>
    </div>

    <div class="right menu">
      <div class="borderless item">
        <a id="userbutton" class="ui right labeled icon teal button" href="{{route('admin.authenticate-logout')}}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
        	<i class="caret down icon" style="color: #fff;"></i> Logout
        </a>

        <form id="logout-form" action="{{ route('admin.authenticate-logout') }}" method="POST" style="display: none;">
                                        {{csrf_field()}}
                                    </form>

      </div>
    </div>

  </div>

</div>
 @yield('content')

 
</body>
 <!--- Component JS -->
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/iframe-content.js') }}"></script>
  <script type="text/javascript" src="{{asset('js/all.js') }}"></script>

@yield('script')
<script>
	$('.ui.checkbox')
  .checkbox()
;
$('.dropdown')
  .dropdown()
;

$('#regInnkommende .ui.checkbox')
.checkbox({
    onChecked: function() {
      $('#regInnkommende .datepicker').addClass('dont-show');
  },
    onUnchecked: function() {
     $('#regInnkommende .datepicker').removeClass('dont-show');
    }})
;


$('#regUtgaende .ui.checkbox')
.checkbox({
    onChecked: function() {
      $('#regUtgaende .datepicker').addClass('dont-show');
  },
    onUnchecked: function() {
     $('#regUtgaende .datepicker').removeClass('dont-show');
    }})
;
</script>
</html>

