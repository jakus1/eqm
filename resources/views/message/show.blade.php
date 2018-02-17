@extends('layouts.default')

@section('title')
Message 
@stop
@section('page-id-container')
	<small># <span ng-bind="messagectrl.message.id"></span></small>
@stop

@section('ang-controller') ng-controller="MessageCtrl as messagectrl" data-ng-init="messagectrl.getMessage('{{$the_record->id}}');" 
@stop


@section('data')
<div class="row">
	<div class="col-md-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				<pre><span ng-bind="messagectrl.message | json"></span></pre>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-8">
		{!! Core::_include_module('mvmnt::modules.journals',$the_record) !!}  
	</div>
	<div class="col-lg-4">
		{!! Core::_include_module('mvmnt::modules.attachments',$the_record) !!} 
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		{!! Core::_include_module('mvmnt::modules.tags',$the_record) !!} 
	</div>
	<div class="col-lg-4">
		{!! Core::_include_module('mvmnt::modules.addresses',$the_record) !!} 
	</div>
	<div class="col-lg-4">
		{!! Core::_include_module('mvmnt::modules.phones',$the_record) !!}  
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		{!! Core::_include_module('mvmnt::modules.changes',$the_record) !!} 
	</div>
	<div class="col-lg-4">
		{!! Core::_include_module('mvmnt::modules.approvals',$the_record) !!}  
	</div>
</div>
@stop

@section('html_footer')
@parent

@stop