@extends('layouts.modal')

@section('title')
Member Detail
@stop

@section('header')
@parent
	
@stop

@section('content')
	<div>
		<pre><span ng-bind="member | json"></span></pre>
	</div>

@stop
