@extends('layouts.module')

@section('mod_title')
<i class="fa fa-map-marker margin-r-5"></i> Message module &nbsp;(<span ng-hide="messagectrl.isLoaded"><i class="fa fa-refresh fa-spin"></i></span><span ng-bind="messagectrl.messages.length"></span>)
@overwrite

@section('box_options')
@overwrite

@section('ibox_class')
@overwrite

@section('mod_controller')
	class="text-muted" 
	ng-controller="MessageCtrl as messagectrl" 
	ng-init="messagectrl.getMessagesModule({{ $the_record->id }},'{!! \Core::getModelCode($the_record)  !!}');"
@overwrite

@section('mod_add_link')
{!! Core::_link('\App\Http\Controllers\MessagesController@create',
	[
		'params'=>
		[
			'parentType'=> \Core::getModelCode($the_record), 
			'parentId'=>$the_record->id
		], 
		'link_text'=>'<i class="fa fa-plus"></i>',
		'addtl_class'=>'pull-right btn btn-success btn-xs',
		'attr' => [
			'data-expect' => 'MessageCtrl.create'
		]
	]
) !!}
@overwrite

@section('mod_content')
<div class="box-body" id="chat-box">
	<table class="table no-margin">
		<thead>
			<tr>
				<th class="[[column.class]]" ng-repeat="column in messagectrl.columns">
					<a href='javascript:void(0);' ng-click="messagectrl.sortBy(column.field)">
						<span ng-bind="column.title"></span>
					</a>&nbsp;
					<span ng-show="field == column.field" class="sortmessage" ng-class="{reverse:messagectrl.isReverse}">
						<i class="fa" ng-class="{'fa-sort-asc':messagectrl.isReverse, 'fa-sort-desc':!messagectrl.isReverse}"></i>
					</span>
				</th>
				<th class="col-sm-2"></th>
			</tr>
		</thead>
		<tbody>
			<tr dir-paginate="message in messagectrl.messages | orderBy:messagectrl.field:messagectrl.isReverse | filter:messagectrl.searchQry | itemsPerPage: messagectrl.pageSize" class="deletable-container" >
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
					{!! Core::_link('\App\Http\Controllers\MessagesController@destroy',[
						'params'=>['[[message.id]]'],
						'link_text'=>'<i class="fa fa-trash text-danger"></i>',
						'ngClick'=>'messagectrl.deleteMessage(message.id,$index)'
					])!!}
				</td>
			</tr>
		</tbody>
	</table>
</div>
@overwrite
