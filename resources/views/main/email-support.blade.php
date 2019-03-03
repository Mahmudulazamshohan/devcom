@extends('layouts.main')
@section('content')
   <div class="card-layout-1">
      <h1 class="email-h1">Email support for users </h1>
      <p style="color: #555;">If you need any kind of support,you can email us from below there...</p>
      <div class="form-box-email">

      	<div class="ui form">
		    <div class="required field">
		      <label>Name</label>
		      <input type="text" placeholder="Please enter name">
		    </div>
		    <div class="required field">
		      <label>Email</label>
		      <input type="text" placeholder="Please enter email address">
		    </div>
		    <div class="required field">
		      <label>Subject</label>
		      <input type="text" placeholder="Please enter subject">
		    </div>
		    <div class="required field">
		      <label>Message</label>
		      <textarea rows="8" placeholder="Please enter your message"></textarea>
		    </div>
		    <button class="ui button primary">Submit</button>
		</div>
      </div>
   </div>

@endsection