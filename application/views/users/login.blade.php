@layout('layouts.default')

@section('content')
	<div class="form-signin">
		<h1>Login</h1>
		{{ Form::open('login', 'POST') }}

		{{ Form::token() }}

		<p>
			{{ Form::text('username', Input::old('username'), array('placeholder' => 'Username')) }}
		</p>	

		<p>
			{{ Form::password('password', array('placeholder' => 'Password')) }}
		</p>	

		<p>{{ Form::submit('Login') }}</p>	

		{{ Form::close() }}
		<p class="form-hints">Forgot your Password?<a href="#"> Reset</a></p>
		<p class="form-hints">New to Rhubarb<a href="#"> Sign Up</a></p>
	</div>
@endsection