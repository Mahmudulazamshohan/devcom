
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
 <link rel="stylesheet" href="{{asset('js/inc/TimeCircles.css') }}">

 <style>
 .item2{
  background: #eee;
 }
 </style>

</head>

<body>
  <nav>
    <div class="ui top fixed secondary menu">
      <a class="item" href="{{route('home')}}">
        <div class="icon">{{ env('APP_NAME') }}</div>
      </a>
  <div class="right menu" style="margin-right: 20px;">
    
      <a href="{{ route('register') }}" class="ui item" style="margin: 0;">
        Signup
      </a>

  </div>
</div>
  </nav>
<div class="content mr-ten" style="margin-top:54px !important;height: 109%;" >
  <div class="grid grid-col-4 grid-space-3" >
    <div class="item1" style="border:none;background:rgba(0,0,0,0) !important;">
      
    </div>
    <div class="item2" style="background:rgba(0,0,0,0) !important;">
      @yield('content')
    </div>
    <div class="item3" id="it3" style="background:rgba(0,0,0,0) !important;border:none;">
      
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

            <li>Teams</li>
            <li>About</li>
            <li>Privacy Policy</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="items">
      <div class="ui list" style="padding: 10px !important;margin-top:10px;">
        <div class="item">
          <ul>
       
            <li>Teams</li>
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
          
            <li>Questions</li>
            <li>Jobs</li>
            <li>Helps</li>
          </ul>
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
  <script type="text/javascript" src="{{ asset('js/inc/TimeCircles.js') }}"></script>

@yield('script')
<script type="text/javascript">

 $('.ui.search')
  .search({
    minCharacters : 1,
    apiSettings: {
      url: '{{route('api.search')}}?q={query}',
      onResponse: function(githubResponse) {
        console.log(githubResponse);
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
          
          console.log(response);
        return response;
      }
    }});
</script>

</html>