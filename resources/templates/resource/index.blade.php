@@extends('layouts.list')

@@section('title')
{{ $Model or '' }}
@@endsection

@@section('ang-controller')
	ng-controller="{{ $Model or '' }}Ctrl as {{ $model or '' }}ctrl" 
	ng-init="{{ $model or '' }}ctrl.get{{ $Models or '' }}();"
@@stop

@@section('create-link')
	(<span ng-if="!{{ $model or '' }}ctrl.isLoaded"><i class="fa fa-refresh fa-spin"></i></span><span ng-bind="({{ $model or '' }}ctrl.{{ $models or '' }}|filter:{{ $model or '' }}ctrl.searchQry).length"></span>)
	@{!! Core::_link('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@create',[
	 	'link_text'=>'<i class="fa fa-plus"></i>',
	 	'attr'=>[
	 		'data-expect'=>'{{ $Model or '' }}Ctrl.create'
 		]
	])!!}
@@endsection

@@section('search')
<div>	
	<div class="form-group">
		<div class="input-group" ng-if="!{{ $model or '' }}ctrl.isTabulated" >
			<select 
				class="form-control input-sm" 
				ng-model="{{ $model or '' }}ctrl.orderField" 
				ng-options="column.title for column in {{ $model or '' }}ctrl.columns track by column.field" 
				ng-change="{{ $model or '' }}ctrl.sortBy(orderField.field);"
			>
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-click="{{ $model or '' }}ctrl.sortBy(field);">
					<i ng-if="!{{ $model or '' }}ctrl.isReverse" class="fa fa-sort-amount-asc" aria-hidden="true"></i>
					<i ng-if="{{ $model or '' }}ctrl.isReverse" class="fa fa-sort-amount-desc" aria-hidden="true"></i>
				</button>
			</span>
		</div>
	</div>
	{{-- <a href="javascript:void(0);" ng-click="changeFilterTo()"><span ng-bind="searchAdvText"></span></a> --}}
	<div class="form-group">
		<div class="input-group"  ng-if="!{{ $model or '' }}ctrl.isAdvanceSearch">
			<input type="text" class="form-control input-sm" placeholder="Search" ng-model='{{ $model or '' }}ctrl.searchQry.$' />
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-bind="{{ $model or '' }}ctrl.searchAdvText" ng-click="{{ $model or '' }}ctrl.changeFilterTo()"></button>
			</span>
		</div>
	</div>
	<div class="form-group">
		<div class="input-group" id="advanced_search" ng-if="{{ $model or '' }}ctrl.isAdvanceSearch && !{{ $model or '' }}ctrl.isTabulated">
			<select 
				class="form-control input-sm" 
				ng-model="{{ $model or '' }}ctrl.newSearchField" 
				ng-options="column.title for column in {{ $model or '' }}ctrl.columns track by column.field" 
				ng-change="{{ $model or '' }}ctrl.addSearchField(newSearchField);"
			>
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-bind="{{ $model or '' }}ctrl.searchAdvText" ng-click="{{ $model or '' }}ctrl.changeFilterTo()"></button>
			</span>
		</div>
	</div>
	<div class="form-group form-inline text-right" ng-repeat="searchField in {{ $model or '' }}ctrl.searchFields" ng-if="{{ $model or '' }}ctrl.isAdvanceSearch && !{{ $model or '' }}ctrl.isTabulated">
		<label class="inline" for="" ng-bind="searchField.title"></label>:
		<input type="text" class="form-control input-sm" id="secondSearchField" placeholder="Search" dynamic-ng-model="'{{ $model or '' }}ctrl.searchQry.'+searchField.field"  />
	</div>
</div>
@@endsection

@@section('buttons')
<input type="text" class="form-control" placeholder="Search Database" ng-model-options='{ debounce: 1000 }' ng-model='{{ $model or '' }}ctrl.searchDB' ng-change="{{ $model or '' }}ctrl.search{{ $Models or '' }}();" />
@@endsection

@@section('tabulated_data')
		<table class='table table-striped col-md-12' >
			<thead>
			<tr>
				<th class="[[column.class]]" ng-repeat="column in {{ $model or '' }}ctrl.columns">
					<a href='javascript:void(0);' ng-click="{{ $model or '' }}ctrl.sortBy(column.field)">
						<span ng-bind="column.title"></span>
					</a>&nbsp;
					<span ng-show="field == column.field" class="sortorder" ng-class="{reverse:{{ $model or '' }}ctrl.isReverse}">
						<i class="fa" ng-class="{'fa-sort-asc':{{ $model or '' }}ctrl.isReverse, 'fa-sort-desc':!{{ $model or '' }}ctrl.isReverse}"></i>
					</span>
				</th>
				<th colspan="3">Action</th>
			</tr>
			</thead>
			<tr id='advanced_search' class="info" ng-if="{{ $model or '' }}ctrl.isAdvanceSearch">
@foreach($fields as $field)
@if(isset($field['name']))
				<td><input type='text' ng-model='{{ $model or '' }}ctrl.searchQry.{{ strtolower($field['name']) }}' class="form-control" placeholder="{{ $field['label'] or '' }}"/></td>
@endif
@endforeach
				<td colspan="3"></td>
			</tr>
			<tbody>
				<tr ng-hide="{{ $model or '' }}ctrl.isLoaded"><td colspan="7"><i class="fa fa-refresh fa-spin"></i> Loading...</td></tr>
				<tr ng-show="({{ $model or '' }}ctrl.{{ $models or '' }}).length == 0 && {{ $model or '' }}ctrl.{{ $model or '' }}ctrl.isLoaded"><td colspan="7">There are no items for {{ $models or '' }} yet. </td></tr>
				<tr dir-paginate="{{ $model or '' }} in {{ $model or '' }}ctrl.{{ $models or '' }} | orderBy:{{ $model or '' }}ctrl.field:{{ $model or '' }}ctrl.isReverse | filter:{{ $model or '' }}ctrl.searchQry | itemsPerPage: {{ $model or '' }}ctrl.pageSize">
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
						@{!! Core::_link('\{{ $namespace or '' }}\Http\Controllers\ApiController@delete{{ $Model or '' }}',[
							'params'=>['[[{{ $model or '' }}.id]]'],
							'link_text'=>'<i class="fa fa-trash text-danger"></i>',
							'ngClick'=>'{{ $model or '' }}ctrl.delete{{ $Model or '' }}({{ $model or '' }}.id,$index)'
						])!!}
					</td>
				</tr>   
			</tbody>
		</table>
@@endsection

@@section('nontabulated_data')
		<div dir-paginate="{{ $model or '' }} in {{ $model or '' }}ctrl.{{ $models or '' }} | orderBy:{{ $model or '' }}ctrl.field:{{ $model or '' }}ctrl.isReverse | filter:{{ $model or '' }}ctrl.searchQry | itemsPerPage: {{ $model or '' }}ctrl.pageSize">
@foreach($fields as $field)
@if(isset($field['name']))
			<p><span ng-bind="{{ $model or '' }}.{{ strtolower($field['name']) }}"></span></p>
@endif
@endforeach
			<div class="pull-right">
				@{!! Core::_link('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@show',[
					'params'=>['[[{{ $model or '' }}.id]]'],
					'link_text'=>'<i class="fa fa-eye"></i>',
					'attr'=>['data-item'=>'{{ $model or '' }}']
				])!!}
				@{!! Core::_link('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@edit',[
					'params'=>['[[{{ $model or '' }}.id]]'],
					'link_text'=>'<i class="fa fa-edit"></i>',
					'attr'=>[
						'data-item'=>'{{ $model or '' }}',
						'data-expect'=>'{{ $Model or '' }}Ctrl.update'
					]
				]) !!}
				@{!! Core::_link('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@destroy',[
					'params'=>['[[{{ $model or '' }}.id]]'],
					'link_text'=>'<i class="fa fa-trash text-danger"></i>',
					'ngClick'=>'{{ $model or '' }}ctrl.delete{{ $Model or '' }}({{ $model or '' }}.id,$index)'
				])!!}
			</div>
		</div>
@@endsection

@@section('data')
		<div ng-if="{{ $model or '' }}ctrl.{{ $model or '' }}ctrl.length == 0 && {{ $model or '' }}ctrl.{{ $model or '' }}Count > 0" class="alert alert-warning" role="alert">Too many {{ $models or '' }} found:<strong><span ng-bind="{{ $model or '' }}Count"></span></strong></div>
		<div ng-if="{{ $model or '' }}ctrl.{{ $model or '' }}ctrl.length == 0 && {{ $model or '' }}ctrl.{{ $model or '' }}Count == 0" class="alert alert-warning" role="alert">No {{ $Model or '' }} matched your search!</div>
		@@yield('tabulated_data')
		{{-- @@yield('nontabulated_data') --}}
@@endsection

@@section('pagesize')
<input type="number" min="1" max="100" size='10' class="form-control pageSize" ng-model="{{ $model or '' }}ctrl.pageSize">
@@endsection

@@section('html_footer')
@@parent

@@stop
