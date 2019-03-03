@extends('layouts.main')
@section('content')
  <div class="card-container">
  	<div class="ui grid">
  		<div class="sixteen wide column" style="padding: 30px;">
         <h2 style="padding: 10px;border-bottom: 1px solid #ccc;color:#555;">Achievements</h2>
         <p style="padding: 10px;">Besides gaining reputation with your questions and answers, you receive badges for being especially helpful. Badges appear on your profile page, flair, and your posts.</p>
         <h3 style="color: #555;border-bottom: 1px solid #ccc;padding-bottom: 10px;">Badges information</h3>
  			<div class="ui top attached tabular menu">
          <a class="item active" data-tab="all">All</a>
          <a class="item" data-tab="earn">Earn</a>
          <a class="item" data-tab="gold">Gold</a>
          <a class="item" data-tab="silver">Silver</a>
          <a class="item" data-tab="bronze">Bronze</a>
          <a class="item" data-tab="score">Readiness Test Score</a>
        </div>
        <div class="ui bottom attached tab segment active" data-tab="all">
        @foreach($badges as $badge)
         {{--  Grid  --}}
          <div class="ui grid border-bottom-one">
            <div class="four wide column">
              <div class="ui label grey">
                @if($badge->badge == 'gold')
                 <i class="trophy label-gold icon"></i>
                @elseif($badge->badge == 'bronze')
                  <i class="trophy label-bronze icon"></i>
                @elseif($badge->badge == 'silver')
                  <i class="trophy label-silver icon"></i>
                @endif
                  {{$badge->badge_name}}
               </div>
             
            </div>
            <div class="twelve wide column">
                <p>{{$badge->badge_title}}</p>
            </div>
          </div>
          {{--  Grid  --}}
          @endforeach
          
        </div>
        <div class="ui bottom attached tab segment" data-tab="earn">
          @if(!count($achievements)) 
            <h3>Not Found</h3>
          @endif
          @foreach($achievements as $achievement)
         {{--  Grid  --}}
          <div class="ui grid border-bottom-one">
            <div class="four wide column">
              <div class="ui label grey">
                @if($achievement->badge == 'gold')
                 <i class="trophy label-gold icon"></i>
                @elseif($achievement->badge == 'bronze')
                  <i class="trophy label-bronze icon"></i>
                @elseif($achievement->badge == 'silver')
                  <i class="trophy label-silver icon"></i>
                @endif
                  {{$achievement->badge_name}}
               </div>
             
            </div>
            <div class="twelve wide column">
                <p>{{$achievement->points}} points</p>
            </div>
          </div>
          {{--  Grid  --}}
          @endforeach
        </div>
        <div class="ui bottom attached tab segment" data-tab="gold">
          @if(!count($golds)) 
            <h3>Not Found</h3>
          @endif
          @foreach($golds as $g)
         {{--  Grid  --}}
          <div class="ui grid border-bottom-one">
            <div class="four wide column">
              <div class="ui label grey">
                @if($g->badge == 'gold')
                 <i class="trophy label-gold icon"></i>
                @elseif($g->badge == 'bronze')
                  <i class="trophy label-bronze icon"></i>
                @elseif($g->badge == 'silver')
                  <i class="trophy label-silver icon"></i>
                @endif
                  {{$g->badge_name}}
               </div>
             
            </div>
            <div class="twelve wide column">
                <p>{{$g->points}} points</p>
            </div>
          </div>
          {{--  Grid  --}}
          @endforeach
        </div>
        <div class="ui bottom attached tab segment" data-tab="silver">
          @if(!count($silvers)) 
            <h3>Not Found</h3>
          @endif
         @foreach($silvers as $s)
         {{--  Grid  --}}
          <div class="ui grid border-bottom-one">
            <div class="four wide column">
              <div class="ui label grey">
                @if($s->badge == 'gold')
                 <i class="trophy label-gold icon"></i>
                @elseif($s->badge == 'bronze')
                  <i class="trophy label-bronze icon"></i>
                @elseif($s->badge == 'silver')
                  <i class="trophy label-silver icon"></i>
                @endif
                   {{$s->badge_name}}
               </div>
             
            </div>
            <div class="twelve wide column">
                <p>{{$s->points}} points</p>
            </div>
          </div>
          {{--  Grid  --}}
          @endforeach
        </div>
        <div class="ui bottom attached tab segment" data-tab="bronze">
           @if(!count($bronzes)) 
            <h3>Not Found</h3>
          @endif
         @foreach($bronzes as $b)
         {{--  Grid  --}}
          <div class="ui grid border-bottom-one">
            <div class="four wide column">
              <div class="ui label grey">
                @if($b->badge == 'gold')
                 <i class="trophy label-gold icon"></i>
                @elseif($b->badge == 'bronze')
                  <i class="trophy label-bronze icon"></i>
                @elseif($b->badge == 'silver')
                  <i class="trophy label-silver icon"></i>
                @endif
                  {{$b->badge_name}}
               </div>
             
            </div>
            <div class="twelve wide column">
                <p>{{$b->points}} points</p>
            </div>
          </div>
          {{--  Grid  --}}
          @endforeach

        </div>
        <div class="ui bottom attached tab segment" data-tab="score">
          <div>

             <a class="ui inverted button green " href="{{ route('test-question-category') }}"> <i class="fa fa-2x fa-question-circle" style="color:green"></i>&nbsp;Take A Test</a>
          </div>
          
        </div>
  		</div>
      <div class="sixteen wide column">
       <div style="padding:30px; ">
         <h2 style="border-bottom: 1px solid #ccc;color: #555;font-family: 'Roboto';padding-bottom: 10px;">Tag Badges</h2>
         {{--  Grid  --}}
          <div class="ui grid border-bottom-one">
            <div class="four wide column">
              <div class="ui label grey">    
                 <i class="trophy label-gold icon"></i>Gold Badge
           
               </div>
             
            </div>
            <div class="twelve wide column">
                <p>You must have a total score of 100 in at least 20 non-community wiki answers to achieve this badge.</p>
            </div>
          </div>
          {{--  Grid  --}}
          {{--  Grid  --}}
          <div class="ui grid border-bottom-one">
            <div class="four wide column">
              <div class="ui label grey">
               
                
                  <i class="trophy label-bronze icon"></i>Bronze Badge
          
           
               </div>
             
            </div>
            <div class="twelve wide column">
                <p>You must have a total score of 400 in at least 80 non-community wiki answers to achieve this badge.</p>
            </div>
          </div>
          {{--  Grid  --}}
          {{--  Grid  --}}
          <div class="ui grid border-bottom-one">
            <div class="four wide column">
              <div class="ui label grey">
               
                
                
          
                 <i class="trophy label-silver icon"></i>Silver Badge
           
               </div>
             
            </div>
            <div class="twelve wide column">
                <p>You must have a total score of 100 in at least 20 non-community wiki answers to achieve this badge.</p>
            </div>
          </div>
          {{--  Grid  --}}
       </div>
      </div>

  	</div>
  	 {{-- <div class="badge-achive">
  	 			<div class="badge-achive-status gold"></div>
  	 			<div class="badge-achive-text">
  	 				Favourite Questions
  	 			</div>
  	 </div> --}}
  </div>
@endsection
@section('script')
 <script type="text/javascript">
   $('.menu .item').tab();
 </script>
@endsection