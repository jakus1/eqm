@extends ('layouts.master')

@section('content')
	<div class="col-sm-8 blog-main">
		<h1>Create a message</h1>

		<hr>

		{!! Form::open(['action' => 'MessagesController@store']) !!}
			<!-- POST method implied -->
			<div class="form-group">
				{!! Form::label('tags', 'Tags:') !!}
				{!! Form::text('tags', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('communication_type', 'Communication Type:') !!}
				{!! Form::select('communication_type', ['SMS' => 'SMS', 'Email' => 'Email', 'Both' => 'Both'], 'S', ['class' => 'form-control']) !!}
			</div>	
			
			<div class="form-group">
				{!! Form::label('subject', 'Subject:') !!}
				{!! Form::text('subject', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('body', 'Message Body:') !!}
				{!! Form::textarea('body', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::submit('Submit Message', ['class' => 'btn btn-primary pull-right']) !!}
				<a href="{{ action('MembersController@index') }}" class="add-button-spacing btn btn-primary pull-right">Cancel</a>
			</div>

			<div class="form-group">
				@include ('layouts.errors')
			</div>
		{!! Form::close() !!}
	</div>
@endsection
