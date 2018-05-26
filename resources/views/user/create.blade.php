@extends ('layouts.master')

@section('content')
	<div class="col-sm-8 blog-main">
		<h1>Create a user</h1>

		<hr>

		{!! Form::open(['method' => 'post', 'action' => 'UsersController@store']) !!}
			<div class="form-group">
				{!! Form::label('name', 'Name:') !!}
				{!! Form::text('name', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('email', 'Email:') !!}
				{!! Form::email('email', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('password', 'Password:') !!}
				{!! Form::password('password', ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('password_confirmation', 'Password Confirmation:') !!}
				{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
					{!! Form::submit('Create User', ['class' => 'btn btn-primary pull-right']) !!}
					<a href="{{ action('MembersController@index') }}" class="add-button-spacing btn btn-primary pull-right">Cancel</a>
			</div>
			
			<div class="form-group">
					@include ('layouts.errors')
			</div>
		{!! Form::close() !!}
	</div>
@endsection
