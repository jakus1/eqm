@extends('layouts.modal')

@section('title')
Message Detail
@stop

@section('header')
@parent
	
@stop

@section('content')
	<div>
		<pre><span ng-bind="message | json"></span></pre>
	</div>

@stop
