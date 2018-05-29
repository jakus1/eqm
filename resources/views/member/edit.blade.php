@extends ('layouts.master')

@section('content')
	<div class="col-sm-8 blog-main">
		<h1>Update {{ $member->first }} {{ $member->last }}</h1>

		<hr>

		{!! Form::model($member, ['method' => 'put', 'action' => ['MembersController@update', $member]]) !!}
			<div class="form-group">
				{!! Form::label('first', 'First Name:') !!}
				{!! Form::text('first', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('last', 'Last Name:') !!}
				{!! Form::text('last', null, ['class' => 'form-control']) !!}
			</div>		

			<div class="form-group">
				{!! Form::label('status', 'Status:') !!}
				{!! Form::select('status', ['Active'=>'Active','Dormant'=>'Dormant'],null, array('class' => 'form-control','placeholder'=>'Choose...')) !!}
			</div>

			<div class="form-group">
				{!! Form::label('sms_phone', 'Phone for SMS Messages:') !!}
				{!! Form::text('sms_phone', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('email', 'Email Address:') !!}
				{!! Form::email('email', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('receives_email', 'Receives Email:') !!}
				{!! Form::select('receives_email', ['No','Yes'],null, array('class' => 'form-control','placeholder'=>'Choose...')) !!}
			</div>

			<div class="form-group">
				{!! Form::label('receives_text', 'Receives Text:') !!}
				{!! Form::select('receives_text', ['No','Yes'],null, array('class' => 'form-control','placeholder'=>'Choose...')) !!}
			</div>

			<div class="form-group">
				{!! Form::submit('Update Member', ['class' => 'btn btn-primary', 'style' => 'margin: 0 6px']) !!}
				<a href="{{ action('MembersController@show', $member) }}" class="btn btn-primary pull-right">Cancel</a>
			</div>

			<div class="form-group">
				@include ('layouts.errors')
			</div>
		{!! Form::close() !!}
	</div>
@endsection
