@extends('layouts.main-2')
@section('content')


 <div class="card-layout-1">
    <div class="card">
    	<h1><i class="fa fa-question-circle"></i>&ensp;Readiness Test </h1>
    	<div class="ui grid mr">
    	@foreach($test_categories as $test_categorie)
		  <div class="four wide column">
		  	<div class="content-area">
		    		<div class="content-header">
		    			<a href="{{route('test-question',['id'=>$test_categorie->id])}}">
		    				<p>
		    					<i class="fa fa-check"></i>
		    				</p>
		    				<p>{{ucfirst($test_categorie->name)}}</p>
		    				
		    			</a>
		    		</div>
		    	</div>
		  </div>
		  @endforeach
        </div>
        <div style="float:right;">
        	{{$test_categories->links()}}
        </div>
    	
    </div>
 </div>
@endsection
@section('script')
<script>
  
</script>
<style type="text/css">
  .footer{
  	margin-top: 0px !important;
  }
   body{
   	background: #242729;
   }
  .content{
  	background: url('https://images.pexels.com/photos/169573/pexels-photo-169573.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');
  	background-size: cover;
  	background-position: 100% 100%;
  	background-repeat: no-repeat;
  	height: 100%;
  	width: 100%;
  	padding-top: 10px;
  }
	.content-area{
		background:#4CAF50;
		border-radius: 4px;
		height: 100px;
		box-shadow: 0px 1px 1px rgba(0,0,0,.2),0px 2px 5px rgba(0,0,0,.2),0px 2px 5px rgba(0,0,0,.2),0px 1px 1px rgba(0,0,0,.01);
	}
	.content-area .content-header{
		width: 100%;
		height: 100%;
		position: relative;

	}
	.content-header a{
		position: absolute;
		padding: 13px;
		height: 100%;
		width: 100%;
		display: flex;
		flex-direction: column;
		color:#fff;
	}
	.content-header a p{
		text-align: center;
	}
	h1{
		color:#555;
		border-bottom: 0.06em dashed #555;
		padding-bottom: 10px;
	}
	.mr{
		padding: 10px !important;
	}
</style>
@endsection
