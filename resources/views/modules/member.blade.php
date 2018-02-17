@extends('layouts.module')

@section('mod_title')
<i class="fa fa-map-marker margin-r-5"></i> Member module &nbsp;(<span ng-hide="memberctrl.isLoaded"><i class="fa fa-refresh fa-spin"></i></span><span ng-bind="memberctrl.members.length"></span>)
@overwrite

@section('box_options')
@overwrite

@section('ibox_class')
@overwrite

@section('mod_controller')
	class="text-muted" 
	ng-controller="MemberCtrl as memberctrl" 
	ng-init="memberctrl.getMembersModule({{ $the_record->id }},'{!! \Core::getModelCode($the_record)  !!}');"
@overwrite

@section('mod_add_link')
{!! Core::_link('\App\Http\Controllers\MembersController@create',
	[
		'params'=>
		[
			'parentType'=> \Core::getModelCode($the_record), 
			'parentId'=>$the_record->id
		], 
		'link_text'=>'<i class="fa fa-plus"></i>',
		'addtl_class'=>'pull-right btn btn-success btn-xs',
		'attr' => [
			'data-expect' => 'MemberCtrl.create'
		]
	]
) !!}
@overwrite

@section('mod_content')
<div class="box-body" id="chat-box">
	<table class="table no-margin">
		<thead>
			<tr>
				<th class="[[column.class]]" ng-repeat="column in memberctrl.columns">
					<a href='javascript:void(0);' ng-click="memberctrl.sortBy(column.field)">
						<span ng-bind="column.title"></span>
					</a>&nbsp;
					<span ng-show="field == column.field" class="sortmember" ng-class="{reverse:memberctrl.isReverse}">
						<i class="fa" ng-class="{'fa-sort-asc':memberctrl.isReverse, 'fa-sort-desc':!memberctrl.isReverse}"></i>
					</span>
				</th>
				<th class="col-sm-2"></th>
			</tr>
		</thead>
		<tbody>
			<tr dir-paginate="member in memberctrl.members | orderBy:memberctrl.field:memberctrl.isReverse | filter:memberctrl.searchQry | itemsPerPage: memberctrl.pageSize" class="deletable-container" >
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
					{!! Core::_link('\App\Http\Controllers\MembersController@destroy',[
						'params'=>['[[member.id]]'],
						'link_text'=>'<i class="fa fa-trash text-danger"></i>',
						'ngClick'=>'memberctrl.deleteMember(member.id,$index)'
					])!!}
				</td>
			</tr>
		</tbody>
	</table>
</div>
@overwrite
