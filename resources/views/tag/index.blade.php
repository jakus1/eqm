@extends('layouts.list')

@section('title')
Tag
@endsection

@section('ang-controller')
	ng-controller="TagCtrl as tagctrl" 
	ng-init="tagctrl.getTags();"
@stop

@section('create-link')
	(<span ng-if="!tagctrl.isLoaded"><i class="fa fa-refresh fa-spin"></i></span><span ng-bind="(tagctrl.tags|filter:tagctrl.searchQry).length"></span>)
	{!! Core::_link('\App\Http\Controllers\TagsController@create',[
	 	'link_text'=>'<i class="fa fa-plus"></i>',
	 	'attr'=>[
	 		'data-expect'=>'TagCtrl.create'
 		]
	])!!}
@endsection

@section('search')
<div>	
	<div class="form-group">
		<div class="input-group" ng-if="!tagctrl.isTabulated" >
			<select 
				class="form-control input-sm" 
				ng-model="tagctrl.orderField" 
				ng-options="column.title for column in tagctrl.columns track by column.field" 
				ng-change="tagctrl.sortBy(orderField.field);"
			>
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-click="tagctrl.sortBy(field);">
					<i ng-if="!tagctrl.isReverse" class="fa fa-sort-amount-asc" aria-hidden="true"></i>
					<i ng-if="tagctrl.isReverse" class="fa fa-sort-amount-desc" aria-hidden="true"></i>
				</button>
			</span>
		</div>
	</div>
	
	<div class="form-group">
		<div class="input-group"  ng-if="!tagctrl.isAdvanceSearch">
			<input type="text" class="form-control input-sm" placeholder="Search" ng-model='tagctrl.searchQry.$' />
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-bind="tagctrl.searchAdvText" ng-click="tagctrl.changeFilterTo()"></button>
			</span>
		</div>
	</div>
	<div class="form-group">
		<div class="input-group" id="advanced_search" ng-if="tagctrl.isAdvanceSearch && !tagctrl.isTabulated">
			<select 
				class="form-control input-sm" 
				ng-model="tagctrl.newSearchField" 
				ng-options="column.title for column in tagctrl.columns track by column.field" 
				ng-change="tagctrl.addSearchField(newSearchField);"
			>
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default input-sm" type="button" ng-bind="tagctrl.searchAdvText" ng-click="tagctrl.changeFilterTo()"></button>
			</span>
		</div>
	</div>
	<div class="form-group form-inline text-right" ng-repeat="searchField in tagctrl.searchFields" ng-if="tagctrl.isAdvanceSearch && !tagctrl.isTabulated">
		<label class="inline" for="" ng-bind="searchField.title"></label>:
		<input type="text" class="form-control input-sm" id="secondSearchField" placeholder="Search" dynamic-ng-model="'tagctrl.searchQry.'+searchField.field"  />
	</div>
</div>
@endsection

@section('buttons')
<input type="text" class="form-control" placeholder="Search Database" ng-model-options='{ debounce: 1000 }' ng-model='tagctrl.searchDB' ng-change="tagctrl.searchTags();" />
@endsection

@section('tabulated_data')
		<table class='table table-striped col-md-12' >
			<thead>
			<tr>
				<th class="[[column.class]]" ng-repeat="column in tagctrl.columns">
					<a href='javascript:void(0);' ng-click="tagctrl.sortBy(column.field)">
						<span ng-bind="column.title"></span>
					</a>&nbsp;
					<span ng-show="field == column.field" class="sortorder" ng-class="{reverse:tagctrl.isReverse}">
						<i class="fa" ng-class="{'fa-sort-asc':tagctrl.isReverse, 'fa-sort-desc':!tagctrl.isReverse}"></i>
					</span>
				</th>
				<th colspan="3">Action</th>
			</tr>
			</thead>
			<tr id='advanced_search' class="info" ng-if="tagctrl.isAdvanceSearch">
				<td><input type='text' ng-model='tagctrl.searchQry.tag' class="form-control" placeholder="Tag"/></td>
				<td><input type='text' ng-model='tagctrl.searchQry.taggable' class="form-control" placeholder="Taggable"/></td>
				<td colspan="3"></td>
			</tr>
			<tbody>
				<tr ng-hide="tagctrl.isLoaded"><td colspan="7"><i class="fa fa-refresh fa-spin"></i> Loading...</td></tr>
				<tr ng-show="(tagctrl.tags).length == 0 && tagctrl.tagctrl.isLoaded"><td colspan="7">There are no items for tags yet. </td></tr>
				<tr dir-paginate="tag in tagctrl.tags | orderBy:tagctrl.field:tagctrl.isReverse | filter:tagctrl.searchQry | itemsPerPage: tagctrl.pageSize">
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
						{!! Core::_link('\App\Http\Controllers\ApiController@deleteTag',[
							'params'=>['[[tag.id]]'],
							'link_text'=>'<i class="fa fa-trash text-danger"></i>',
							'ngClick'=>'tagctrl.deleteTag(tag.id,$index)'
						])!!}
					</td>
				</tr>   
			</tbody>
		</table>
@endsection

@section('nontabulated_data')
		<div dir-paginate="tag in tagctrl.tags | orderBy:tagctrl.field:tagctrl.isReverse | filter:tagctrl.searchQry | itemsPerPage: tagctrl.pageSize">
			<p><span ng-bind="tag.tag"></span></p>
			<p><span ng-bind="tag.taggable"></span></p>
			<div class="pull-right">
				{!! Core::_link('\App\Http\Controllers\TagsController@show',[
					'params'=>['[[tag.id]]'],
					'link_text'=>'<i class="fa fa-eye"></i>',
					'attr'=>['data-item'=>'tag']
				])!!}
				{!! Core::_link('\App\Http\Controllers\TagsController@edit',[
					'params'=>['[[tag.id]]'],
					'link_text'=>'<i class="fa fa-edit"></i>',
					'attr'=>[
						'data-item'=>'tag',
						'data-expect'=>'TagCtrl.update'
					]
				]) !!}
				{!! Core::_link('\App\Http\Controllers\TagsController@destroy',[
					'params'=>['[[tag.id]]'],
					'link_text'=>'<i class="fa fa-trash text-danger"></i>',
					'ngClick'=>'tagctrl.deleteTag(tag.id,$index)'
				])!!}
			</div>
		</div>
@endsection

@section('data')
		<div ng-if="tagctrl.tagctrl.length == 0 && tagctrl.tagCount > 0" class="alert alert-warning" role="alert">Too many tags found:<strong><span ng-bind="tagCount"></span></strong></div>
		<div ng-if="tagctrl.tagctrl.length == 0 && tagctrl.tagCount == 0" class="alert alert-warning" role="alert">No Tag matched your search!</div>
		@yield('tabulated_data')
		
@endsection

@section('pagesize')
<input type="number" min="1" max="100" size='10' class="form-control pageSize" ng-model="tagctrl.pageSize">
@endsection

@section('html_footer')
@parent

@stop
