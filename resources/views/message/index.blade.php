@extends('layouts.list')

@section('title')
Message
@endsection

@section('ang-controller')
	ng-controller="MessageCtrl as messagectrl" 
	ng-init="messagectrl.getMessages();"
@stop

@section('create-link')
	(<span ng-if="!messagectrl.isLoaded"><i class="fa fa-refresh fa-spin"></i></span><span ng-bind="(messagectrl.messages|filter:messagectrl.searchQry).length"></span>)
	{!! Core::_link('\App\Http\Controllers\MessagesController@create',[
	 	'link_text'=>'<i class="fa fa-plus"></i>',
	 	'attr'=>[
	 		'data-expect'=>'MessageCtrl.create'
 		]
	])!!}
@endsection

@section('search')
<div>	
	<div class="form-group">
		<div class="input-group" ng-if="!messagectrl.isTabulated" >
			<select 
				class="form-control input-sm" 
				ng-model="messagectrl.orderField" 
				ng-options="column.title for column in messagectrl.columns track by column.field" 
				ng-change="messagectrl.sortBy(orderField.field);"
			>
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-click="messagectrl.sortBy(field);">
					<i ng-if="!messagectrl.isReverse" class="fa fa-sort-amount-asc" aria-hidden="true"></i>
					<i ng-if="messagectrl.isReverse" class="fa fa-sort-amount-desc" aria-hidden="true"></i>
				</button>
			</span>
		</div>
	</div>
	
	<div class="form-group">
		<div class="input-group"  ng-if="!messagectrl.isAdvanceSearch">
			<input type="text" class="form-control input-sm" placeholder="Search" ng-model='messagectrl.searchQry.$' />
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-bind="messagectrl.searchAdvText" ng-click="messagectrl.changeFilterTo()"></button>
			</span>
		</div>
	</div>
	<div class="form-group">
		<div class="input-group" id="advanced_search" ng-if="messagectrl.isAdvanceSearch && !messagectrl.isTabulated">
			<select 
				class="form-control input-sm" 
				ng-model="messagectrl.newSearchField" 
				ng-options="column.title for column in messagectrl.columns track by column.field" 
				ng-change="messagectrl.addSearchField(newSearchField);"
			>
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-bind="messagectrl.searchAdvText" ng-click="messagectrl.changeFilterTo()"></button>
			</span>
		</div>
	</div>
	<div class="form-group form-inline text-right" ng-repeat="searchField in messagectrl.searchFields" ng-if="messagectrl.isAdvanceSearch && !messagectrl.isTabulated">
		<label class="inline" for="" ng-bind="searchField.title"></label>:
		<input type="text" class="form-control input-sm" id="secondSearchField" placeholder="Search" dynamic-ng-model="'messagectrl.searchQry.'+searchField.field"  />
	</div>
</div>
@endsection

@section('buttons')
<input type="text" class="form-control" placeholder="Search Database" ng-model-options='{ debounce: 1000 }' ng-model='messagectrl.searchDB' ng-change="messagectrl.searchMessages();" />
@endsection

@section('tabulated_data')
		<table class='table table-striped col-md-12' >
			<thead>
			<tr>
				<th class="[[column.class]]" ng-repeat="column in messagectrl.columns">
					<a href='javascript:void(0);' ng-click="messagectrl.sortBy(column.field)">
						<span ng-bind="column.title"></span>
					</a>&nbsp;
					<span ng-show="field == column.field" class="sortorder" ng-class="{reverse:messagectrl.isReverse}">
						<i class="fa" ng-class="{'fa-sort-asc':messagectrl.isReverse, 'fa-sort-desc':!messagectrl.isReverse}"></i>
					</span>
				</th>
				<th colspan="3">Action</th>
			</tr>
			</thead>
			<tr id='advanced_search' class="info" ng-if="messagectrl.isAdvanceSearch">
				<td><input type='text' ng-model='messagectrl.searchQry.body' class="form-control" placeholder="Body"/></td>
				<td colspan="3"></td>
			</tr>
			<tbody>
				<tr ng-hide="messagectrl.isLoaded"><td colspan="7"><i class="fa fa-refresh fa-spin"></i> Loading...</td></tr>
				<tr ng-show="(messagectrl.messages).length == 0 && messagectrl.messagectrl.isLoaded"><td colspan="7">There are no items for messages yet. </td></tr>
				<tr dir-paginate="message in messagectrl.messages | orderBy:messagectrl.field:messagectrl.isReverse | filter:messagectrl.searchQry | itemsPerPage: messagectrl.pageSize">
					<td><span ng-bind="message.body"></span></td>
					<td class="action">
						{!! Core::_link('\App\Http\Controllers\MessagesController@show',[
							'params'=>['[[message.id]]'],
							'link_text'=>'<i class="fa fa-eye"></i>',
							'attr'=>['data-item'=>'message']
						])!!}
					</td>
					<td>
						{!! Core::_link('\App\Http\Controllers\MessagesController@edit',[
							'params'=>['[[message.id]]'],
							'link_text'=>'<i class="fa fa-edit"></i>',
							'attr'=>[
								'data-item'=>'message',
								'data-expect'=>'MessageCtrl.update'
							]
						]) !!}
					</td>
					<td>
						{!! Core::_link('\App\Http\Controllers\ApiController@deleteMessage',[
							'params'=>['[[message.id]]'],
							'link_text'=>'<i class="fa fa-trash text-danger"></i>',
							'ngClick'=>'messagectrl.deleteMessage(message.id,$index)'
						])!!}
					</td>
				</tr>   
			</tbody>
		</table>
@endsection

@section('nontabulated_data')
		<div dir-paginate="message in messagectrl.messages | orderBy:messagectrl.field:messagectrl.isReverse | filter:messagectrl.searchQry | itemsPerPage: messagectrl.pageSize">
			<p><span ng-bind="message.body"></span></p>
			<div class="pull-right">
				{!! Core::_link('\App\Http\Controllers\MessagesController@show',[
					'params'=>['[[message.id]]'],
					'link_text'=>'<i class="fa fa-eye"></i>',
					'attr'=>['data-item'=>'message']
				])!!}
				{!! Core::_link('\App\Http\Controllers\MessagesController@edit',[
					'params'=>['[[message.id]]'],
					'link_text'=>'<i class="fa fa-edit"></i>',
					'attr'=>[
						'data-item'=>'message',
						'data-expect'=>'MessageCtrl.update'
					]
				]) !!}
				{!! Core::_link('\App\Http\Controllers\MessagesController@destroy',[
					'params'=>['[[message.id]]'],
					'link_text'=>'<i class="fa fa-trash text-danger"></i>',
					'ngClick'=>'messagectrl.deleteMessage(message.id,$index)'
				])!!}
			</div>
		</div>
@endsection

@section('data')
		<div ng-if="messagectrl.messagectrl.length == 0 && messagectrl.messageCount > 0" class="alert alert-warning" role="alert">Too many messages found:<strong><span ng-bind="messageCount"></span></strong></div>
		<div ng-if="messagectrl.messagectrl.length == 0 && messagectrl.messageCount == 0" class="alert alert-warning" role="alert">No Message matched your search!</div>
		@yield('tabulated_data')
		
@endsection

@section('pagesize')
<input type="number" min="1" max="100" size='10' class="form-control pageSize" ng-model="messagectrl.pageSize">
@endsection

@section('html_footer')
@parent

@stop
