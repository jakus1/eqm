@extends ('layouts.master')

@section('content')
  <div class="col-sm-8 blog-main">
    <h1>Create a member</h1>

    <hr>

		{!! Form::open(['url' => '/member', 'method' => 'post', 'action' => 'MembersController@store']) !!}
		<div class="form-group">
			{!! Form::label('first', 'First Name:') !!}
			{!! Form::text('first', '', ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('last', 'Last Name:') !!}
			{!! Form::text('last', '', ['class' => 'form-control']) !!}
		</div>		

		<div class="form-group">
				{!! Form::label('sms_phone', 'Phone for SMS Messages:') !!}
				{!! Form::text('sms_phone', '', ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('email', 'Email Address:') !!}
			{!! Form::email('email', ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
				{!! Form::submit('Create Member', ['class' => 'btn btn-primary']) !!}
		</div>

		<div class="form-group">
				@include ('layouts.errors')
		</div>
	{!! Form::close() !!}
  </div>
@endsection
