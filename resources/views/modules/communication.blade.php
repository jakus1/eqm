@extends('layouts.module')

@section('mod_title')
<i class="fa fa-map-marker margin-r-5"></i> Communication module &nbsp;(<span ng-hide="communicationctrl.isLoaded"><i class="fa fa-refresh fa-spin"></i></span><span ng-bind="communicationctrl.communications.length"></span>)
@overwrite

@section('box_options')
@overwrite

@section('ibox_class')
@overwrite

@section('mod_controller')
	class="text-muted" 
	ng-controller="CommunicationCtrl as communicationctrl" 
	ng-init="communicationctrl.getCommunicationsModule({{ $the_record->id }},'{!! \Core::getModelCode($the_record)  !!}');"
@overwrite

@section('mod_add_link')
{!! Core::_link('\App\Http\Controllers\CommunicationsController@create',
	[
		'params'=>
		[
			'parentType'=> \Core::getModelCode($the_record), 
			'parentId'=>$the_record->id
		], 
		'link_text'=>'<i class="fa fa-plus"></i>',
		'addtl_class'=>'pull-right btn btn-success btn-xs',
		'attr' => [
			'data-expect' => 'CommunicationCtrl.create'
		]
	]
) !!}
@overwrite

@section('mod_content')
<div class="box-body" id="chat-box">
	<table class="table no-margin">
		<thead>
			<tr>
				<th class="[[column.class]]" ng-repeat="column in communicationctrl.columns">
					<a href='javascript:void(0);' ng-click="communicationctrl.sortBy(column.field)">
						<span ng-bind="column.title"></span>
					</a>&nbsp;
					<span ng-show="field == column.field" class="sortcommunication" ng-class="{reverse:communicationctrl.isReverse}">
						<i class="fa" ng-class="{'fa-sort-asc':communicationctrl.isReverse, 'fa-sort-desc':!communicationctrl.isReverse}"></i>
					</span>
				</th>
				<th class="col-sm-2"></th>
			</tr>
		</thead>
		<tbody>
			<tr dir-paginate="communication in communicationctrl.communications | orderBy:communicationctrl.field:communicationctrl.isReverse | filter:communicationctrl.searchQry | itemsPerPage: communicationctrl.pageSize" class="deletable-container" >
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
					{!! Core::_link('\App\Http\Controllers\CommunicationsController@destroy',[
						'params'=>['[[communication.id]]'],
						'link_text'=>'<i class="fa fa-trash text-danger"></i>',
						'ngClick'=>'communicationctrl.deleteCommunication(communication.id,$index)'
					])!!}
				</td>
			</tr>
		</tbody>
	</table>
</div>
@overwrite
