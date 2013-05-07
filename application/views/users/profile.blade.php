@layout('layouts.default')

@section('content')

<div class="row-fluid" style="margin-top:20px;">
	
<div class="span12">

	<h2>{{$user->username}}'s Profile</h2>
	<div class="span6 userInfoContainer">
		@if(Session::get('message'))
			{{Session::get('message')}}
		@endif

		<div class="profilepicture">
			<img src="{{$user->image_thumb}}" class="profile_photo" name="profile_photo" >
			<!-- <img src="{{$user->image_small_thumb}}" class="profile_photo_small" name="profile_photo_small" /> -->
		</div>
		<div class="name">{{$user->firstname}}</div>
		<div class="lastname">{{$user->lastname}}</div>
		<div class="email">{{$user->email}}</div>
		<div class="registered">You were registered on {{date('d-m-Y',strtotime($user->created_at))}}</div>
		<div class="updated">You last updated your profile on {{date('d-m-Y',strtotime($user->updated_at))}}</div>
		<div class="span12">
			<a href="javascript:void(0);" class="updateInfoAnchor btn">Update Info</a>
		<a href="javascript:void(0);" class="changepassword btn">Change Password</a>
		</div>
	</div>
	<div class="span6 updateinfo">
		{{Form::open_for_files('profile','POST', array('class' => 'profileupdate')) }}	
	
		{{Form::label('firstname', 'First Name', array('class' => 'span4 text firstname'))}}
		{{Form::text('firstname', $user->firstname)}}
		{{Form::label('lastname', 'Last Name', array('class' => 'span4 text lastname'))}}
		{{Form::text('lastname', $user->lastname)}}
		{{Form::label('email', 'Email Address', array('class' => 'span4 text email'))}}
		{{Form::text('email', $user->email)}}
		{{Form::label('Change Profile Picture', 'Change Profile Picture', array('class' => 'span4'))}}
		<input type="file" name="profile_picture" class="picture" id="picture" /><br />		
		{{Form::button('Update Info',array('class'=>'btn'))}}
		{{Form::close()}}
	</div>
	<div class="span6 changepasswordhere">
		{{Form::open('changepassword', 'POST', array('class' => 'changepasswordform'))}}	
	
		{{Form::label('New Password', 'New Password', array('class' => 'span4 text newpassword'))}}
		{{Form::password('new_password')}}
		{{Form::label('re_password', 'Re enter password', array('class' => 'span4 text reenterpassword'))}}
		{{Form::password('password_confirmation')}}
		{{Form::button('Update Password',array('class'=>'btn'))}}
		{{Form::close()}}
	</div>
</div>
</div>

@endsection

@section('footer_script')
{{HTML::script('js/jquery-1.8.2.min.js')}}
	
<script>
	
	$(function() {
		
		$('div.updateinfo').hide();
		$('.changepasswordhere').hide();

		$('.updateInfoAnchor').on('click',function(e) {
			e.preventDefault();
			$('.changepasswordhere').hide();
			$('.updateInfo').toggle();
		});

		$('.changepassword').on('click',function(e) {
			e.preventDefault();
			$('.changepasswordform')[0].reset();
			$('.updateInfo').hide();
			$('.changepasswordhere').toggle();
		})

	});

</script>



@endsection
@section('profile_picture_smallthumbnail')
<img src="{{$user->image_small_thumb}}" class="profile_photo_small" name="profile_photo_small" />
@endsection

