@extends('layouts.module')

@section('mod_title')
<i class="fa fa-map-marker margin-r-5"></i> Tag module &nbsp;(<span ng-hide="tagctrl.isLoaded"><i class="fa fa-refresh fa-spin"></i></span><span ng-bind="tagctrl.tags.length"></span>)
@overwrite

@section('box_options')
@overwrite

@section('ibox_class')
@overwrite

@section('mod_controller')
	class="text-muted" 
	ng-controller="TagCtrl as tagctrl" 
	ng-init="tagctrl.getTagsModule({{ $the_record->id }},'{!! \Core::getModelCode($the_record)  !!}');"
@overwrite

@section('mod_add_link')
{!! Core::_link('\App\Http\Controllers\TagsController@create',
	[
		'params'=>
		[
			'parentType'=> \Core::getModelCode($the_record), 
			'parentId'=>$the_record->id
		], 
		'link_text'=>'<i class="fa fa-plus"></i>',
		'addtl_class'=>'pull-right btn btn-success btn-xs',
		'attr' => [
			'data-expect' => 'TagCtrl.create'
		]
	]
) !!}
@overwrite

@section('mod_content')
<div class="box-body" id="chat-box">
	<table class="table no-margin">
		<thead>
			<tr>
				<th class="[[column.class]]" ng-repeat="column in tagctrl.columns">
					<a href='javascript:void(0);' ng-click="tagctrl.sortBy(column.field)">
						<span ng-bind="column.title"></span>
					</a>&nbsp;
					<span ng-show="field == column.field" class="sorttag" ng-class="{reverse:tagctrl.isReverse}">
						<i class="fa" ng-class="{'fa-sort-asc':tagctrl.isReverse, 'fa-sort-desc':!tagctrl.isReverse}"></i>
					</span>
				</th>
				<th class="col-sm-2"></th>
			</tr>
		</thead>
		<tbody>
			<tr dir-paginate="tag in tagctrl.tags | orderBy:tagctrl.field:tagctrl.isReverse | filter:tagctrl.searchQry | itemsPerPage: tagctrl.pageSize" class="deletable-container" >
				<td><span ng-bind="tag.tag"></span></td>
				<td><span ng-bind="tag.taggable"></span></td>
				<td class="action">
					{!! Core::_link('\App\Http\Controllers\TagsController@show',[
						'params'=>['[[tag.id]]'],
						'link_text'=>'<i class="fa fa-eye"></i>',
						'attr'=>['data-item'=>'tag']
					])!!}
				</td>
				<td>
					{!! Core::_link('\App\Http\Controllers\TagsController@edit',[
						'params'=>['[[tag.id]]'],
						'link_text'=>'<i class="fa fa-edit"></i>',
						'attr'=>[
							'data-item'=>'tag',
							'data-expect'=>'TagCtrl.update'
						]
					]) !!}
				</td>
				<td>
					{!! Core::_link('\App\Http\Controllers\TagsController@destroy',[
						'params'=>['[[tag.id]]'],
						'link_text'=>'<i class="fa fa-trash text-danger"></i>',
						'ngClick'=>'tagctrl.deleteTag(tag.id,$index)'
					])!!}
				</td>
			</tr>
		</tbody>
	</table>
</div>
@overwrite
