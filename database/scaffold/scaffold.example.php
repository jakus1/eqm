<?php

/*
 |--------------------------------------------------------------------------
 | Model scaffolding
 |--------------------------------------------------------------------------
 |
 | Here you can create your models based on options from an array.
 |
 */

/*##############################################################################################

##############################################################################################
{{ $namespace or '' }}
{{ $model or '' }}
{{ $models or '' }}
{{ $Model or '' }}
{{ $Models or '' }}

@foreach($fields as $field)
@if(isset($field['name']))
{{ strtolower($field['name']) }}
{{ $field['name'] }}
@endif
@endforeach

##############################################################################################

##############################################################################################*/

return [
	'namespace' => 'App',
	'table' => 'categories',
	'name'   => 'Category',
	'fields' => [
		[
			'type' => 'string',
			'name' => 'name',
		],
		[
			'type' => 'text',
			'name' => 'description',
		],
		[
			'type'   => 'integer',
			'name'   => 'count',
			'extras' => ['unsigned', 'unique', 'index', 'nullable']

		],
		[
			'type' => 'decimal',
			'name' => 'amount',
			'params' => [
				'length' => 10,
				'precision' => 2
			],
  		],
		[
			'type' => 'timestamps'
		],
		[
			'type' => 'softDeletes'
		],
	],
	'fillable' => [
		'name', 'description', 'count',
	],
	'relations' => [
		[
			'type' => 'belongsToMany',
			'name' => 'Task',
		],
		[
			'type' => 'belongsToMany',
			'name' => 'Tasktmpl',
		],
	],
];
