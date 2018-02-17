@@extends('layouts.module')

@@section('mod_title')
<i class="fa fa-map-marker margin-r-5"></i> {{ $Model or '' }} module &nbsp;(<span ng-hide="{{ $model or '' }}ctrl.isLoaded"><i class="fa fa-refresh fa-spin"></i></span><span ng-bind="{{ $model or '' }}ctrl.{{ $models or '' }}.length"></span>)
@@overwrite

@@section('box_options')
@@overwrite

@@section('ibox_class')
@@overwrite

@@section('mod_controller')
	class="text-muted" 
	ng-controller="{{ $Model or '' }}Ctrl as {{ $model or '' }}ctrl" 
	ng-init="{{ $model or '' }}ctrl.get{{ $Models or '' }}Module(@{{ $the_record->id }},'@{!! \Core::getModelCode($the_record)  !!}');"
@@overwrite

@@section('mod_add_link')
@{!! Core::_link('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@create',
	[
		'params'=>
		[
			'parentType'=> \Core::getModelCode($the_record), 
			'parentId'=>$the_record->id
		], 
		'link_text'=>'<i class="fa fa-plus"></i>',
		'addtl_class'=>'pull-right btn btn-success btn-xs',
		'attr' => [
			'data-expect' => '{{ $Model or '' }}Ctrl.create'
		]
	]
) !!}
@@overwrite

@@section('mod_content')
<div class="box-body" id="chat-box">
	<table class="table no-margin">
		<thead>
			<tr>
				<th class="[[column.class]]" ng-repeat="column in {{ $model or '' }}ctrl.columns">
					<a href='javascript:void(0);' ng-click="{{ $model or '' }}ctrl.sortBy(column.field)">
						<span ng-bind="column.title"></span>
					</a>&nbsp;
					<span ng-show="field == column.field" class="sort{{ $model or '' }}" ng-class="{reverse:{{ $model or '' }}ctrl.isReverse}">
						<i class="fa" ng-class="{'fa-sort-asc':{{ $model or '' }}ctrl.isReverse, 'fa-sort-desc':!{{ $model or '' }}ctrl.isReverse}"></i>
					</span>
				</th>
				<th class="col-sm-2"></th>
			</tr>
		</thead>
		<tbody>
			<tr dir-paginate="{{ $model or '' }} in {{ $model or '' }}ctrl.{{ $models or '' }} | orderBy:{{ $model or '' }}ctrl.field:{{ $model or '' }}ctrl.isReverse | filter:{{ $model or '' }}ctrl.searchQry | itemsPerPage: {{ $model or '' }}ctrl.pageSize" class="deletable-container" >
@foreach($fields as $field)
@if(isset($field['name']))
				<td><span ng-bind="{{ $model or '' }}.{{ strtolower($field['name']) }}"></span></td>
@endif
@endforeach
				<td class="action">
					@{!! Core::_link('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@show',[
						'params'=>['[[{{ $model or '' }}.id]]'],
						'link_text'=>'<i class="fa fa-eye"></i>',
						'attr'=>['data-item'=>'{{ $model or '' }}']
					])!!}
				</td>
				<td>
					@{!! Core::_link('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@edit',[
						'params'=>['[[{{ $model or '' }}.id]]'],
						'link_text'=>'<i class="fa fa-edit"></i>',
						'attr'=>[
							'data-item'=>'{{ $model or '' }}',
							'data-expect'=>'{{ $Model or '' }}Ctrl.update'
						]
					]) !!}
				</td>
				<td>
					@{!! Core::_link('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@destroy',[
						'params'=>['[[{{ $model or '' }}.id]]'],
						'link_text'=>'<i class="fa fa-trash text-danger"></i>',
						'ngClick'=>'{{ $model or '' }}ctrl.delete{{ $Model or '' }}({{ $model or '' }}.id,$index)'
					])!!}
				</td>
			</tr>
		</tbody>
	</table>
</div>
@@overwrite
