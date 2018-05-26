@extends ('layouts.master')

@section('content')
<div class="col-sm-8 blog-main">
	<h1>Sign in</h1>

	{!! Form::open(['url' => '/login', 'method' => 'post', 'action' => 'SessionsController@store']) !!}
		<div class="form-group">
			{!! Form::label('email', 'Email:') !!}
			{!! Form::email('email', '', ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('password', 'Password:') !!}
			{!! Form::password('password', ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Sign in', ['class' => 'btn btn-primary pull-right']) !!}
		</div>
		
		<div class="form-group">
			@include ('layouts.errors')
		</div>
	{!! Form::close() !!}
</div>
@endsection
