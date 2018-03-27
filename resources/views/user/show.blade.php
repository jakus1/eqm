@extends ('layouts.master')

@section('content')
	<div class="col-sm-8 blog-main">
		<h1>{{ $user->name }}</h1>

		<div class="form-group">
			{!! Form::label('email', 'Email:') !!}
			{{ $user->email }}
		</div>

		{!! Form::open(['url' => '/user/edit', 'method' => 'post', 'action' => 'UsersController@edit']) !!}
		<div class="form-group">
			{!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
		</div>
		
		<div class="form-group">
				@include ('layouts.errors')
		</div>
	{!! Form::close() !!}
	</div>
@endsection