@extends('layouts.modal')

@section('title')
Create New Communication
@stop

@section('header')
@parent
	{!! HTML::ul($errors->all() ) !!}
	{!! Form::open(['action' => '\App\Http\Controllers\ApiController@postCommunication','id'=>'modalForm']) !!}
	<input name="c7token" type="hidden" value="{{ csrf_token() }}" data-ng-init="bind._token='{{ csrf_token() }}'"  data-ng-model="bind._token">
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('body', 'Body') !!}
				{!! Form::text('body', null, array('class' => 'form-control','data-ng-model'=>'bind.body','placeholder'=>'Enter Body')) !!}
			</div>
		</div>	
	</div>
@stop

@section('buttons')
	<div class="form-group text-center">
		{!! Form::button('Create Communication', array('class' => 'btn btn-success','ng-click'=>'ok($event)')) !!}
		{!! Form::button('Cancel',array('class'=>'btn cancel','ng-click'=>'$dismiss()','data-dismiss'=>'modal')) !!}
	</div>
   {!! Form::close() !!}
@stop
