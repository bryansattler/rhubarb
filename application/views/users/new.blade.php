@layout('layouts.default')

@section('content')
	<div class="form-signin">
		<h1>Sign Up</h1>
		<h3>It's free and easy!</h3>

		@if($errors->has())
			<p>The following errors have occurred:</p>

			<ul class ="alert-error text-error">
				{{ $errors->first('username', '<li>:message</li>') }}
				{{ $errors->first('email', '<li>:message</li>') }}
				{{ $errors->first('password', '<li>:message</li>') }}
				{{ $errors->first('password_confirmation', '<li>:message</li>') }}
			</ul>	
		@endif

		{{ Form::open('signup', 'POST') }}

		{{ Form::token() }}

			<p>
			{{ Form::text('username', Input::old('username'), array('placeholder' => 'Username')) }}
			</p>

			<p>
			{{ Form::text('email', Input::old('email'), array('placeholder' => 'Email')) }}
			</p>			

			<p>
			{{ Form::password('password', array('placeholder' => 'Password')) }}
			</p>
			
			<p>
			{{ Form::password('password_confirmation', array('placeholder' => 'Confirm Password')) }}
			</p>
			
			<p>{{ Form::submit('Sign Up') }}</p>

		{{ Form::close() }}
		<p class="form-hints">Already a Member?<a href="#"> Log In</a></p>
	</div>	
@endsection