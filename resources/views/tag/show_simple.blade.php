@extends('layouts.modal')

@section('title')
Tag Detail
@stop

@section('header')
@parent
	
@stop

@section('content')
	<div>
		<pre><span ng-bind="tag | json"></span></pre>
	</div>

@stop
