@extends('layouts.modal')

@section('title')
Communication Detail
@stop

@section('header')
@parent
	
@stop

@section('content')
	<div>
		<pre><span ng-bind="communication | json"></span></pre>
	</div>

@stop
