@extends ('layouts.master')

@section('content')
  <div class="col-sm-8 blog-main">
    <h1>Create a user</h1>

    <hr>

		{!! Form::open(['url' => '/user', 'method' => 'post', 'action' => 'UsersController@store']) !!}
			<div class="form-group">
				{!! Form::label('name', 'Name:') !!}
				{!! Form::text('name', '', ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('email', 'Email:') !!}
				{!! Form::email('email', '', ['class' => 'form-control']) !!}
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
					{!! Form::submit('Create User', ['class' => 'btn btn-primary']) !!}
			</div>
			
			<div class="form-group">
					@include ('layouts.errors')
			</div>
		{!! Form::close() !!}
  </div>
@endsection
