@extends('layouts.team')
@section('content')
 <h3><i class="fa fa-clock-o"></i> Recently Viewed</h3>
 <div class="board-items" style="padding-bottom: 2px !important">
 @foreach($recenty_viewes as $recenty_view)
  <div class="board-items-list">
    <a href="{{route('team.board',[$recenty_view->board_id,$recenty_view->team_board->board_title])}}">
      {{$recenty_view->team_board->board_title}}
    </a>
    <div style="margin-top:10px;">
       <a class="ui button small olive" href="{{route('team.members',$recenty_view->board_id)}}"><i class="fa fa-user"></i> Members</a>  
        <a class="ui button small grey"> <i class="fa fa-dashboard"></i></a>
    </div>
    
  </div>

 @endforeach
 </div>
 <h3><i class="fa fa-user grey-color"></i> Personal Boards</h3>
 <div class="board-items">
 
 @foreach($teamBoardUsers as $teamBoardUser)
  <div class="board-items-list">
    <a href="{{route('team.board',[$teamBoardUser->board_id,$teamBoardUser->team_board->board_title])}}">
      {{$teamBoardUser->team_board->board_title}}
    </a>
    <div style="margin-top:10px;">
       <a class="ui button small olive" href="{{route('team.members',$teamBoardUser->board_id)}}">
        <i class="fa fa-user"></i> Members</a>  
        <a href="{{route('team.board',[$teamBoardUser->board_id,$teamBoardUser->team_board->board_title])}}" class="ui button small grey"> 
          <i class="fa fa-dashboard"></i>
        </a>
    </div>
    
  </div>
  
  
 @endforeach
  </div>
@endsection
@section('script')
 <style type="text/css">
   h3{
   	margin-left: 10px;
   }
 	.board-items{
 		display: grid;
        grid-template-columns: auto auto auto auto;
 		width: 100%;
 		grid-gap: 10px;
 		padding: 10px 100px 100px 18px;
 		

 	}
    .board-items .board-items-list{
    	border-bottom:5px solid #B5CC18;
    	display: flex;
    	flex-direction: column;
    	padding: 20px;
    	background: #fff;
    	width:100% !important;
    	margin-bottom: 4px;
    	border-radius:5px;
    	box-shadow: 0px 2px 2px rgba(0,0,0,.03);
    	background:linear-gradient(to right bottom,
									 rgba(0,0,0,0.4),
									 rgba(0,0,0,0.4)),
									 url('https://images.unsplash.com/photo-1547838555-204e1f648a15?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1366&q=80');
   

    	background-size: cover;
    	background-position: 100% 100%;
    	transition: background-position 2s,border-bottom 800ms ease-in;
    }
    .board-items .board-items-list:hover{
    	background-position: 100% 10%;
    	border-bottom:5px solid #838383;
    }
 	.board-items .board-items-list a{
 		font-size: 22px;
 		font-weight: bold;
 		font-family: 'Roboto';
 		color: #fff;
 		
 		
 	}
  
 </style>
@endsection
