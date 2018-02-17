<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Model definitions file location
	|--------------------------------------------------------------------------
	|
	| This is the location where all of your models definitions are located.
	|   Running "php artisan scaffold:update" will update any models you have
	|   changed.
	|
	*/

	'modelsScaffoldDirectory' => 'database/scaffold',

	/*
	|--------------------------------------------------------------------------
	| Repository Pattern
	|--------------------------------------------------------------------------
	|
	| This is where you define if you want to use the repository pattern.
	|
	| Set baseRepository to true if you want all repositories to derive
	|   from a base repository interface
	|
	*/

	'useRepository' => false,

	'useBaseRepository' => false,

	/*
	|--------------------------------------------------------------------------
	| Application Name
	|--------------------------------------------------------------------------
	|
	| Define the name of your application
	|
	*/

	'appName' => 'Your project',

	/*
	|--------------------------------------------------------------------------
	| Downloads
	|--------------------------------------------------------------------------
	|
	| Set to "true" for those which you would like downloaded with your application.
	| They will also be automatically included in your layout file
	|
	*/

	'downloads' => [

		'jquery1'    => true,
		'jquery2'    => false,
		'bootstrap'  => true,
		'foundation' => false,
		'underscore' => false,
		'handlebars' => false,
		'angular'    => true,
		'ember'      => false,
		'backbone'   => false

	],

	/*
	|--------------------------------------------------------------------------
	| Paths
	|--------------------------------------------------------------------------
	|
	| Specify the path to the following folders
	|
	*/

	'paths' => [

		'templates'            => 'resources/templates',
		'controllers'          => 'app/Http/Controllers',
		'migrations'           => 'database/migrations',
		'seeds'                => 'database/seeds',
		'factory'              => 'database/factories',
		'models'               => 'app/Models',
		'repositories'         => 'app/Repositories',
		'repositoryInterfaces' => 'app/Contracts/Repositories',
		'apitests'             => 'tests/api',
		'acceptancetests'      => 'tests/acceptance',
		'tests'                => 'tests',
		'views'                => 'resources/views',
		'routes'               => 'routes',
		'layout'               => 'resources/views/layouts/default.blade.php',
		'angular'              => 'public/angular',
		'apitrait'             => 'app/Traits/ApiCtrl'

	],

	/*
	|--------------------------------------------------------------------------
	| Dynamic Names
	|--------------------------------------------------------------------------
	|
	| Create your own named variable and include in it the templates!
	|
	| Eg: 'myName' => '[Model] is super fantastic!'
	|
	| Then place [myName] in your template file and it will output "Book is super fantastic!"
	|
	| [model], [models], [Model], or [Models] are valid in the dynamic name
	|
	*/

	'names' => [

		'controller'              => '[Models]Controller',
		'modelName'               => '[Model]',
		'test'                    => '[model]Test',
		'ApiTest'                 => '[model]Cest.php',
		'ControllerTest'          => '[model]ControllerCest.php',
		'repository'              => 'Eloquent[Model]Repository',
		'baseRepositoryInterface' => 'RepositoryInterface',
		'repositoryInterface'     => '[Model]RepositoryInterface',
		'viewFolder'              => '[model]',
		// 'ListCtrl'                => '[model]ListCtrl.js',
		// 'FormCtrl'                => '[model]FormCtrl.js',
		// 'ModCtrl'                 => '[model]ModCtrl.js',
		// 'ViewCtrl'                => '[model]ViewCtrl.js',
		'NgCtrl'                  => '[model]Ctrl.js',
		'NgService'               => '[model]Service.js',
		'apitrait'                => '[Model]Trait',
		'module'                  => '[model].blade.php',
	],

	/*
	|--------------------------------------------------------------------------
	| Views
	|--------------------------------------------------------------------------
	|
	| Specify the names of your views.
	|
	| ***IMPORTANT** Whatever you change the name to, you need to make sure you
	|   have a file with the same name.txt in your templates folder, under
	|   resource and/or restful, depending on the type of controller.
	|
	*/

	'views' => [
		'show',
		'show_simple',
		'edit',
		'create',
		'index',
		'module',
		// 'ViewCtrl',
		// 'FormCtrl',
		// 'ModCtrl',
		// 'ListCtrl',
		'NgCtrl',
		'NgService',
		'ControllerTest',
		'ApiTest',
	],

	'transfers' => [
		'views' => [
			// 'ViewCtrl'       => 'resources/assets/js/angular/controllers',
			// 'FormCtrl'       => 'resources/assets/js/angular/controllers',
			// 'ModCtrl'        => 'resources/assets/js/angular/controllers',
			// 'ListCtrl'       => 'resources/assets/js/angular/controllers',
			'NgCtrl'         => 'resources/assets/js/angular/controllers',
			'NgService'      => 'resources/assets/js/angular/services',
			'module'         => 'resources/views/modules',
			'ApiTest'        => 'tests/api',
			'ControllerTest' => 'tests/functional',
		]
	],

	'routesFiles' => [
		'web.php' => 'controller_routes.php',
		'api.php' => 'api_routes.php',
	]
];
