@layout('layouts.default')

@section('content')
	<div class="form-signin">
		<h1>Login</h1>
		{{ Form::open('login', 'POST') }}

		{{ Form::token() }}

		<p>
			{{ Form::label('username', 'Username') }}
			{{ Form::text('username', Input::old('username')) }}
		</p>	

		<p>
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password') }}
		</p>	

		<p class="">{{ Form::submit('Login') }}</p>	

		{{ Form::close() }}
	</div>
@endsection