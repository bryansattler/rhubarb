@layout('layouts.default')

@section('content')

	@if(!Auth::check())
		
	@else
		<h1>My Watchlist</h1>
		<h4>Movies I want to see go here!</h4>
		@endif
@endsection