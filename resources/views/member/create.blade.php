@extends('layouts.modal')

@section('title')
Create New Member
@stop

@section('header')
@parent
	{!! HTML::ul($errors->all() ) !!}
	{!! Form::open(['action' => '\App\Http\Controllers\ApiController@postMember','id'=>'modalForm']) !!}
	<input name="c7token" type="hidden" value="{{ csrf_token() }}" data-ng-init="bind._token='{{ csrf_token() }}'"  data-ng-model="bind._token">
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('first', 'First') !!}
				{!! Form::text('first', null, array('class' => 'form-control','data-ng-model'=>'bind.first','placeholder'=>'Enter First')) !!}
			</div>
			<div class="form-group">
				{!! Form::label('last', 'Last') !!}
				{!! Form::text('last', null, array('class' => 'form-control','data-ng-model'=>'bind.last','placeholder'=>'Enter Last')) !!}
			</div>
			<div class="form-group">
				{!! Form::label('email', 'Email') !!}
				{!! Form::text('email', null, array('class' => 'form-control','data-ng-model'=>'bind.email','placeholder'=>'Enter Email')) !!}
			</div>
			<div class="form-group">
				{!! Form::label('sms_phone', 'Sms phone') !!}
				{!! Form::text('sms_phone', null, array('class' => 'form-control','data-ng-model'=>'bind.sms_phone','placeholder'=>'Enter Sms phone')) !!}
			</div>
			<div class="form-group">
				{!! Form::label('description', 'Description') !!}
				{!! Form::text('description', null, array('class' => 'form-control','data-ng-model'=>'bind.description','placeholder'=>'Enter Description')) !!}
			</div>
		</div>	
	</div>
@stop

@section('buttons')
	<div class="form-group text-center">
		{!! Form::button('Create Member', array('class' => 'btn btn-success','ng-click'=>'ok($event)')) !!}
		{!! Form::button('Cancel',array('class'=>'btn cancel','ng-click'=>'$dismiss()','data-dismiss'=>'modal')) !!}
	</div>
   {!! Form::close() !!}
@stop
