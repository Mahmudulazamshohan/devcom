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
        </div>
        <div class="ui bottom attached tab segment active" data-tab="all">
         {{--  Grid  --}}
          <div class="ui grid border-bottom-one">
            <div class="four wide column">
              <div class="ui label grey">
                <i class="trophy label-gold icon"></i> Favourite questions
               </div>
             
            </div>
            <div class="twelve wide column">
                <p> First bounty you manually award on another person's question</p>
            </div>
          </div>
          {{--  Grid  --}}
          {{--  Grid  --}}
          <div class="ui grid border-bottom-one">
            <div class="four wide column">
              <div class="ui label grey">
                <i class="trophy label-bronze icon"></i> Nice questions
               </div>
             
            </div>
            <div class="twelve wide column">
                 <p> First bounty you manually award on another person's question</p>
            </div>
          </div>
          {{--  Grid  --}}
         {{--  Grid  --}}
          <div class="ui grid border-bottom-one">
            <div class="four wide column">
              <div class="ui label grey">
                <i class="trophy label-silver icon"></i> Nice questions
               </div>
             
            </div>
            <div class="twelve wide column">
                 <p> First bounty you manually award on another person's question</p>
            </div>
          </div>
          {{--  Grid  --}}
        </div>
        <div class="ui bottom attached tab segment" data-tab="earn">
          Earn
        </div>
        <div class="ui bottom attached tab segment" data-tab="gold">
          Gold
        </div>
        <div class="ui bottom attached tab segment" data-tab="silver">
          silver
        </div>
        <div class="ui bottom attached tab segment" data-tab="bronze">
          bronze
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