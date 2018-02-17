@extends('layouts.list')

@section('title')
Member
@endsection

@section('ang-controller')
	ng-controller="MemberCtrl as memberctrl" 
	ng-init="memberctrl.getMembers();"
@stop

@section('create-link')
	(<span ng-if="!memberctrl.isLoaded"><i class="fa fa-refresh fa-spin"></i></span><span ng-bind="(memberctrl.members|filter:memberctrl.searchQry).length"></span>)
	{!! Core::_link('\App\Http\Controllers\MembersController@create',[
	 	'link_text'=>'<i class="fa fa-plus"></i>',
	 	'attr'=>[
	 		'data-expect'=>'MemberCtrl.create'
 		]
	])!!}
@endsection

@section('search')
<div>	
	<div class="form-group">
		<div class="input-group" ng-if="!memberctrl.isTabulated" >
			<select 
				class="form-control input-sm" 
				ng-model="memberctrl.orderField" 
				ng-options="column.title for column in memberctrl.columns track by column.field" 
				ng-change="memberctrl.sortBy(orderField.field);"
			>
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-click="memberctrl.sortBy(field);">
					<i ng-if="!memberctrl.isReverse" class="fa fa-sort-amount-asc" aria-hidden="true"></i>
					<i ng-if="memberctrl.isReverse" class="fa fa-sort-amount-desc" aria-hidden="true"></i>
				</button>
			</span>
		</div>
	</div>
	
	<div class="form-group">
		<div class="input-group"  ng-if="!memberctrl.isAdvanceSearch">
			<input type="text" class="form-control input-sm" placeholder="Search" ng-model='memberctrl.searchQry.$' />
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-bind="memberctrl.searchAdvText" ng-click="memberctrl.changeFilterTo()"></button>
			</span>
		</div>
	</div>
	<div class="form-group">
		<div class="input-group" id="advanced_search" ng-if="memberctrl.isAdvanceSearch && !memberctrl.isTabulated">
			<select 
				class="form-control input-sm" 
				ng-model="memberctrl.newSearchField" 
				ng-options="column.title for column in memberctrl.columns track by column.field" 
				ng-change="memberctrl.addSearchField(newSearchField);"
			>
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-bind="memberctrl.searchAdvText" ng-click="memberctrl.changeFilterTo()"></button>
			</span>
		</div>
	</div>
	<div class="form-group form-inline text-right" ng-repeat="searchField in memberctrl.searchFields" ng-if="memberctrl.isAdvanceSearch && !memberctrl.isTabulated">
		<label class="inline" for="" ng-bind="searchField.title"></label>:
		<input type="text" class="form-control input-sm" id="secondSearchField" placeholder="Search" dynamic-ng-model="'memberctrl.searchQry.'+searchField.field"  />
	</div>
</div>
@endsection

@section('buttons')
<input type="text" class="form-control" placeholder="Search Database" ng-model-options='{ debounce: 1000 }' ng-model='memberctrl.searchDB' ng-change="memberctrl.searchMembers();" />
@endsection

@section('tabulated_data')
		<table class='table table-striped col-md-12' >
			<thead>
			<tr>
				<th class="[[column.class]]" ng-repeat="column in memberctrl.columns">
					<a href='javascript:void(0);' ng-click="memberctrl.sortBy(column.field)">
						<span ng-bind="column.title"></span>
					</a>&nbsp;
					<span ng-show="field == column.field" class="sortorder" ng-class="{reverse:memberctrl.isReverse}">
						<i class="fa" ng-class="{'fa-sort-asc':memberctrl.isReverse, 'fa-sort-desc':!memberctrl.isReverse}"></i>
					</span>
				</th>
				<th colspan="3">Action</th>
			</tr>
			</thead>
			<tr id='advanced_search' class="info" ng-if="memberctrl.isAdvanceSearch">
				<td><input type='text' ng-model='memberctrl.searchQry.first' class="form-control" placeholder="First"/></td>
				<td><input type='text' ng-model='memberctrl.searchQry.last' class="form-control" placeholder="Last"/></td>
				<td><input type='text' ng-model='memberctrl.searchQry.email' class="form-control" placeholder="Email"/></td>
				<td><input type='text' ng-model='memberctrl.searchQry.sms_phone' class="form-control" placeholder="Sms phone"/></td>
				<td><input type='text' ng-model='memberctrl.searchQry.description' class="form-control" placeholder="Description"/></td>
				<td colspan="3"></td>
			</tr>
			<tbody>
				<tr ng-hide="memberctrl.isLoaded"><td colspan="7"><i class="fa fa-refresh fa-spin"></i> Loading...</td></tr>
				<tr ng-show="(memberctrl.members).length == 0 && memberctrl.memberctrl.isLoaded"><td colspan="7">There are no items for members yet. </td></tr>
				<tr dir-paginate="member in memberctrl.members | orderBy:memberctrl.field:memberctrl.isReverse | filter:memberctrl.searchQry | itemsPerPage: memberctrl.pageSize">
					<td><span ng-bind="member.first"></span></td>
					<td><span ng-bind="member.last"></span></td>
					<td><span ng-bind="member.email"></span></td>
					<td><span ng-bind="member.sms_phone"></span></td>
					<td><span ng-bind="member.description"></span></td>
					<td class="action">
						{!! Core::_link('\App\Http\Controllers\MembersController@show',[
							'params'=>['[[member.id]]'],
							'link_text'=>'<i class="fa fa-eye"></i>',
							'attr'=>['data-item'=>'member']
						])!!}
					</td>
					<td>
						{!! Core::_link('\App\Http\Controllers\MembersController@edit',[
							'params'=>['[[member.id]]'],
							'link_text'=>'<i class="fa fa-edit"></i>',
							'attr'=>[
								'data-item'=>'member',
								'data-expect'=>'MemberCtrl.update'
							]
						]) !!}
					</td>
					<td>
						{!! Core::_link('\App\Http\Controllers\ApiController@deleteMember',[
							'params'=>['[[member.id]]'],
							'link_text'=>'<i class="fa fa-trash text-danger"></i>',
							'ngClick'=>'memberctrl.deleteMember(member.id,$index)'
						])!!}
					</td>
				</tr>   
			</tbody>
		</table>
@endsection

@section('nontabulated_data')
		<div dir-paginate="member in memberctrl.members | orderBy:memberctrl.field:memberctrl.isReverse | filter:memberctrl.searchQry | itemsPerPage: memberctrl.pageSize">
			<p><span ng-bind="member.first"></span></p>
			<p><span ng-bind="member.last"></span></p>
			<p><span ng-bind="member.email"></span></p>
			<p><span ng-bind="member.sms_phone"></span></p>
			<p><span ng-bind="member.description"></span></p>
			<div class="pull-right">
				{!! Core::_link('\App\Http\Controllers\MembersController@show',[
					'params'=>['[[member.id]]'],
					'link_text'=>'<i class="fa fa-eye"></i>',
					'attr'=>['data-item'=>'member']
				])!!}
				{!! Core::_link('\App\Http\Controllers\MembersController@edit',[
					'params'=>['[[member.id]]'],
					'link_text'=>'<i class="fa fa-edit"></i>',
					'attr'=>[
						'data-item'=>'member',
						'data-expect'=>'MemberCtrl.update'
					]
				]) !!}
				{!! Core::_link('\App\Http\Controllers\MembersController@destroy',[
					'params'=>['[[member.id]]'],
					'link_text'=>'<i class="fa fa-trash text-danger"></i>',
					'ngClick'=>'memberctrl.deleteMember(member.id,$index)'
				])!!}
			</div>
		</div>
@endsection

@section('data')
		<div ng-if="memberctrl.memberctrl.length == 0 && memberctrl.memberCount > 0" class="alert alert-warning" role="alert">Too many members found:<strong><span ng-bind="memberCount"></span></strong></div>
		<div ng-if="memberctrl.memberctrl.length == 0 && memberctrl.memberCount == 0" class="alert alert-warning" role="alert">No Member matched your search!</div>
		@yield('tabulated_data')
		
@endsection

@section('pagesize')
<input type="number" min="1" max="100" size='10' class="form-control pageSize" ng-model="memberctrl.pageSize">
@endsection

@section('html_footer')
@parent

@stop
