@layout('layouts.default')

@section('content')

	@if(!Auth::check())
		<h1>Welcome to Rhubarb!</h1>
		<h4>Landing Page stuff goes here!</h4>
	@else

	<?php
	/* 
	*  Need to move this. See "Triggering Events from your Server (PHP)"
	*  http://pusher.com/tutorials/realtime_activity_streams
	*
	*  LOOK AT SHOWCASE FOR IDEAS http://pusher.com/showcase
	*/
	//require_once('activity-streams/src/examples/php/lib/squeeks-Pusher-PHP/lib/Pusher.php');
	//require_once('activity-streams/src/php/Activity.php');
	?>
		<ul id="activity_stream" class="activity-stream"></ul>
	@endif

@endsection