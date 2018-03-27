@extends ('layouts.master')

@section('content')
  <div class="col-sm-8 blog-main">
    <h1>Update {{ $user->name }}</h1>

	<hr>

		{!! Form::model($user, ['method' => 'post', 'action' => ['UsersController@update', $user]]) !!}
			<div class="form-group">
				{!! Form::label('name', 'Name:') !!}
				{!! Form::text('name', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				<!-- Seems like we should prompt for existing password here -->
				{!! Form::label('password', 'New Password:') !!}
				{!! Form::password('password', ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('password_confirmation', 'Password Confirmation:') !!}
				{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
					{!! Form::submit('Update User', ['class' => 'btn btn-primary']) !!}
			</div>
			
			<div class="form-group">
					@include ('layouts.errors')
			</div>
		{!! Form::close() !!}
  </div>
@endsection
