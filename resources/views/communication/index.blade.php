@extends('layouts.list')

@section('title')
Communication
@endsection

@section('ang-controller')
	ng-controller="CommunicationCtrl as communicationctrl" 
	ng-init="communicationctrl.getCommunications();"
@stop

@section('create-link')
	(<span ng-if="!communicationctrl.isLoaded"><i class="fa fa-refresh fa-spin"></i></span><span ng-bind="(communicationctrl.communications|filter:communicationctrl.searchQry).length"></span>)
	{!! Core::_link('\App\Http\Controllers\CommunicationsController@create',[
	 	'link_text'=>'<i class="fa fa-plus"></i>',
	 	'attr'=>[
	 		'data-expect'=>'CommunicationCtrl.create'
 		]
	])!!}
@endsection

@section('search')
<div>	
	<div class="form-group">
		<div class="input-group" ng-if="!communicationctrl.isTabulated" >
			<select 
				class="form-control input-sm" 
				ng-model="communicationctrl.orderField" 
				ng-options="column.title for column in communicationctrl.columns track by column.field" 
				ng-change="communicationctrl.sortBy(orderField.field);"
			>
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-click="communicationctrl.sortBy(field);">
					<i ng-if="!communicationctrl.isReverse" class="fa fa-sort-amount-asc" aria-hidden="true"></i>
					<i ng-if="communicationctrl.isReverse" class="fa fa-sort-amount-desc" aria-hidden="true"></i>
				</button>
			</span>
		</div>
	</div>
	
	<div class="form-group">
		<div class="input-group"  ng-if="!communicationctrl.isAdvanceSearch">
			<input type="text" class="form-control input-sm" placeholder="Search" ng-model='communicationctrl.searchQry.$' />
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-bind="communicationctrl.searchAdvText" ng-click="communicationctrl.changeFilterTo()"></button>
			</span>
		</div>
	</div>
	<div class="form-group">
		<div class="input-group" id="advanced_search" ng-if="communicationctrl.isAdvanceSearch && !communicationctrl.isTabulated">
			<select 
				class="form-control input-sm" 
				ng-model="communicationctrl.newSearchField" 
				ng-options="column.title for column in communicationctrl.columns track by column.field" 
				ng-change="communicationctrl.addSearchField(newSearchField);"
			>
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-bind="communicationctrl.searchAdvText" ng-click="communicationctrl.changeFilterTo()"></button>
			</span>
		</div>
	</div>
	<div class="form-group form-inline text-right" ng-repeat="searchField in communicationctrl.searchFields" ng-if="communicationctrl.isAdvanceSearch && !communicationctrl.isTabulated">
		<label class="inline" for="" ng-bind="searchField.title"></label>:
		<input type="text" class="form-control input-sm" id="secondSearchField" placeholder="Search" dynamic-ng-model="'communicationctrl.searchQry.'+searchField.field"  />
	</div>
</div>
@endsection

@section('buttons')
<input type="text" class="form-control" placeholder="Search Database" ng-model-options='{ debounce: 1000 }' ng-model='communicationctrl.searchDB' ng-change="communicationctrl.searchCommunications();" />
@endsection

@section('tabulated_data')
		<table class='table table-striped col-md-12' >
			<thead>
			<tr>
				<th class="[[column.class]]" ng-repeat="column in communicationctrl.columns">
					<a href='javascript:void(0);' ng-click="communicationctrl.sortBy(column.field)">
						<span ng-bind="column.title"></span>
					</a>&nbsp;
					<span ng-show="field == column.field" class="sortorder" ng-class="{reverse:communicationctrl.isReverse}">
						<i class="fa" ng-class="{'fa-sort-asc':communicationctrl.isReverse, 'fa-sort-desc':!communicationctrl.isReverse}"></i>
					</span>
				</th>
				<th colspan="3">Action</th>
			</tr>
			</thead>
			<tr id='advanced_search' class="info" ng-if="communicationctrl.isAdvanceSearch">
				<td><input type='text' ng-model='communicationctrl.searchQry.body' class="form-control" placeholder="Body"/></td>
				<td colspan="3"></td>
			</tr>
			<tbody>
				<tr ng-hide="communicationctrl.isLoaded"><td colspan="7"><i class="fa fa-refresh fa-spin"></i> Loading...</td></tr>
				<tr ng-show="(communicationctrl.communications).length == 0 && communicationctrl.communicationctrl.isLoaded"><td colspan="7">There are no items for communications yet. </td></tr>
				<tr dir-paginate="communication in communicationctrl.communications | orderBy:communicationctrl.field:communicationctrl.isReverse | filter:communicationctrl.searchQry | itemsPerPage: communicationctrl.pageSize">
					<td><span ng-bind="communication.body"></span></td>
					<td class="action">
						{!! Core::_link('\App\Http\Controllers\CommunicationsController@show',[
							'params'=>['[[communication.id]]'],
							'link_text'=>'<i class="fa fa-eye"></i>',
							'attr'=>['data-item'=>'communication']
						])!!}
					</td>
					<td>
						{!! Core::_link('\App\Http\Controllers\CommunicationsController@edit',[
							'params'=>['[[communication.id]]'],
							'link_text'=>'<i class="fa fa-edit"></i>',
							'attr'=>[
								'data-item'=>'communication',
								'data-expect'=>'CommunicationCtrl.update'
							]
						]) !!}
					</td>
					<td>
						{!! Core::_link('\App\Http\Controllers\ApiController@deleteCommunication',[
							'params'=>['[[communication.id]]'],
							'link_text'=>'<i class="fa fa-trash text-danger"></i>',
							'ngClick'=>'communicationctrl.deleteCommunication(communication.id,$index)'
						])!!}
					</td>
				</tr>   
			</tbody>
		</table>
@endsection

@section('nontabulated_data')
		<div dir-paginate="communication in communicationctrl.communications | orderBy:communicationctrl.field:communicationctrl.isReverse | filter:communicationctrl.searchQry | itemsPerPage: communicationctrl.pageSize">
			<p><span ng-bind="communication.body"></span></p>
			<div class="pull-right">
				{!! Core::_link('\App\Http\Controllers\CommunicationsController@show',[
					'params'=>['[[communication.id]]'],
					'link_text'=>'<i class="fa fa-eye"></i>',
					'attr'=>['data-item'=>'communication']
				])!!}
				{!! Core::_link('\App\Http\Controllers\CommunicationsController@edit',[
					'params'=>['[[communication.id]]'],
					'link_text'=>'<i class="fa fa-edit"></i>',
					'attr'=>[
						'data-item'=>'communication',
						'data-expect'=>'CommunicationCtrl.update'
					]
				]) !!}
				{!! Core::_link('\App\Http\Controllers\CommunicationsController@destroy',[
					'params'=>['[[communication.id]]'],
					'link_text'=>'<i class="fa fa-trash text-danger"></i>',
					'ngClick'=>'communicationctrl.deleteCommunication(communication.id,$index)'
				])!!}
			</div>
		</div>
@endsection

@section('data')
		<div ng-if="communicationctrl.communicationctrl.length == 0 && communicationctrl.communicationCount > 0" class="alert alert-warning" role="alert">Too many communications found:<strong><span ng-bind="communicationCount"></span></strong></div>
		<div ng-if="communicationctrl.communicationctrl.length == 0 && communicationctrl.communicationCount == 0" class="alert alert-warning" role="alert">No Communication matched your search!</div>
		@yield('tabulated_data')
		
@endsection

@section('pagesize')
<input type="number" min="1" max="100" size='10' class="form-control pageSize" ng-model="communicationctrl.pageSize">
@endsection

@section('html_footer')
@parent

@stop
