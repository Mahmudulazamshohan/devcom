
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <title>DevCom | Community system for developers</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" type="text/css" href="{{ asset('styles/bundle.css') }}">
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/components/icon.min.css'>
  <link href="https://fonts.googleapis.com/css?family=Quattrocento|Ceviche+One|Lakki+Reddy|Merienda|Shrikhand|Roboto|Josefin+Sans|Unlock" rel="stylesheet">
 
  <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet">



</head>

<body>
  <nav>
    <div class="ui top fixed secondary menu">

    <a class="active item" href="{{route('home')}}">
      Home
    </a>
     
    <a class="item" id="board-slide">
     <i class="clipboard icon"></i>  Boards
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
  	
    <button id="createBtn" class="ui item" style="background: #eee;border-radius: 4px !important;">
    	<i class="plus icon"></i> Create
    </button>
  </div>
</div>
  </nav>
 {{--  Sidebar --}}
  <div class="ui sidebar inverted vertical menu" style="padding: 10px;">
    <a class="item" style="color:#000 !important">
      <i class="plus icon" id="board_press"></i>PERSONAL BOARDS
      <div id="board_show">
      	<ul style="list-style-type: none;">
      		<li>1</li>
      		<li>2</li>
      		<li>3</li>
      	</ul>
      </div>
    </a>
    
    <a class="item" style="color:#000 !important" id="create_new_board">
      Create New Board
    </a>
  </div>
  {{--  Sidebar --}}

  <div class="ui modal" id="model">
  <i class="close icon" style="margin:35 !important; color:#555;"></i>
  <div class="header">
    Start Building
  </div>
  <div class="image content">
    <div class="ui medium image">
      <img src="{{asset('images/teams_ui.png')}}">
    </div>
    <div class="description">
      <div class="ui header">
      	<a href="{{route('team.add-board')}}" class="ui positive button">Create Board</a>
      	<p style="font-size: 14px;margin:10px;font-family: arial;color:#555;">A board is made up of cards ordered on lists. Use it to manage projects, track information, or organize anything.</p>
      	{{-- <a href="" class="ui  teal  button">Create Team</a>
      	<p style="font-size: 14px;margin:10px;font-family: arial;color:#555;">A team is a group of boards and people. Use it to organize your company, side hustle, family, or friends.</p> --}}
      	
     </div>
  </div>
  
</div>
</div>

<div class="main-body-team" style="margin-top: 56px;">
  <div class="flex-row" style="display: flex;flex-flow: row;">
    <div class="flex-sidebar" style="flex-grow: 1;">
      <div class="sidebar-ui">
        <a href=""><i class="fa fa-dashboard"></i> Boards</a>
        <a href=""><i class="fa fa-home"></i> Home</a>
      </div>
    </div>
    <div class="flex-body"  style="flex-grow: 3;padding-top: 50px;">
      @yield('content')

    </div>
  </div>
 
</div>


  </body>
   <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/iframe-content.js') }}"></script>
  <script type="text/javascript" src="{{asset('js/all.js') }}"></script>
  <script type="text/javascript">

  $(document).ready(function(){
  	 $("#board_show").hide();
     $('#createBtn').click(function(){
       $('#model').modal('show');
     });
     $('#board-slide').click(function(event) {
     	 $('.ui.sidebar').sidebar('toggle');
     });
    $("#board_press").click(function(){
        $("#board_show").toggle();
    });
  });
  </script>
  @yield('script')

</html>