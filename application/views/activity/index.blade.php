@layout('layouts.default')

@section('content')

	@if(!Auth::check())
		<h1>Welcome to Rhubarb!</h1>
		<h4>Landing Page stuff goes here!</h4>
	@else
		Activity Stream
	@endif

@endsection