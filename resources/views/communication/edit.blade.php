@extends('layouts.modal')

@section('title')
Edit Communication
@stop

@section('header')
@parent
	{!! HTML::ul($errors->all() ) !!}
	{!! Form::model($communication,['action' => ['\App\Http\Controllers\ApiController@putCommunication',$communication->id],'id'=>'modalForm','method' => 'put']) !!}
	<input name="c7token" type="hidden" value="{{ csrf_token() }}" data-ng-init="bind._token='{{ csrf_token() }}'" data-ng-model="bind._token">
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
		{!! Form::button('Save', array('class' => 'btn btn-success','ng-click'=>'ok($event)')) !!}
		{!! Form::button('Cancel',array('class'=>'btn cancel','ng-click'=>'$dismiss()','data-dismiss'=>'modal')) !!}
	</div>
	</form>
@stop
