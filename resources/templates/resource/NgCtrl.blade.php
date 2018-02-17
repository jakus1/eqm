(function(){
	'use strict';
	angular
	.module('myApp')
	.controller('{{ $Model or '' }}Ctrl', {{ $Model or '' }}Ctrl)
	{{ $Model or '' }}Ctrl.$inject = ["$rootScope","$scope","$http","$filter","$uibModal","{{ $Model or '' }}Service","$controller"];
	function {{ $Model or '' }}Ctrl($rootScope,$scope, $http, $filter, $uibModal, {{ $Model or '' }}Service, $controller){
		var ctrl = this;

		//Get the default functionality
		var base = $controller('BaseCtrl', {$scope: $scope});

		angular.extend(this, base)

		ctrl.columns 			= [
@foreach($fields as $field)
@if(isset($field['name']))
			{'class':'col-md-2','field':'{{ $field['name'] }}','title':'{{ $field['label'] or '' }}'},
@endif
@endforeach
		];
		ctrl.orderField 		= ctrl.columns[0];
		ctrl.{{ $models or '' }}			= [];
		ctrl.{{ $model or '' }}			= {};
		ctrl.isTabulated	= false;


		// get all {{ $Models or '' }}
		ctrl.get{{ $Models or '' }} = function(){
			{{ $Model or '' }}Service.getAll{{ $Models or '' }}(ctrl.searchDB)
			.then(function(res){
				ctrl.{{ $models or '' }} = res.data;
				ctrl.sortBy(ctrl.orderField.field);
				ctrl.{{ $model or '' }}Count = res.count;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM get{{ $Models or '' }}: ", err); 
			});
		}

		// get all {{ $Models or '' }} for a specific parent
		ctrl.get{{ $Models or '' }}Module = function(parentId,parentType){
			ctrl.parentId = parentId;
			ctrl.parentType = parentType;
			{{ $Model or '' }}Service.getAll{{ $Models or '' }}ByParent(parentId,parentType)
			.then(function(res){
				ctrl.{{ $models or '' }} = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM get{{ $Models or '' }}: ", err); 
			});
		}

		// get a specific {{ $Model or '' }}
		ctrl.get{{ $Model or '' }} = function({{ $model or '' }}Id){
			{{ $Model or '' }}Service.get{{ $Model or '' }}({{ $model or '' }}Id)
			.then(function(res){
				ctrl.{{ $model or '' }} = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM get{{ $Models or '' }}: ", err); 
			});
		}

		// delete a specific {{ $Model or '' }}
		ctrl.delete{{ $Model or '' }}= function ({{ $model or '' }}Id, idx){
			if(confirm('Are you sure you want to delete this {{ $model or '' }}?')){
				{{ $Model or '' }}Service.delete{{ $Model or '' }}({{ $model or '' }}Id)
				.then(function(res){
					ctrl.{{ $models or '' }}.splice(idx, 1);
					ctrl.fireEvents(res);
				})
				.catch(function(err){
					console.error("ERROR RESPONDING FROM GET ALL USERS: ", err); 
				});
			}
		}

		// Search all {{ $Models or '' }}
		ctrl.search{{ $Models or '' }} = function(){
			{{ $Model or '' }}Service.getAll{{ $Models or '' }}(ctrl.searchDB)
			.then(function(res){
				ctrl.{{ $models or '' }} = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM search{{ $Models or '' }}: ", err); 
			});
		}

		// Events Listeners
		var createListener = $rootScope.$on('{{ $Model or '' }}Ctrl.create', function (event, data) {
			ctrl.{{ $models or '' }}.push(data.payload);
		});
		var updateListener = $rootScope.$on('{{ $Model or '' }}Ctrl.update', function (event, data) {
			var position = ctrl.{{ $models or '' }}.map(function({{ $model or '' }}){
				return {{ $model or '' }}.id;
			}).indexOf(data.id);
			ctrl.{{ $models or '' }}[position] = data;
		});
		var deleteListener = $rootScope.$on('{{ $Model or '' }}Ctrl.destroy', function (event, data) {
			var position = ctrl.{{ $models or '' }}.map(function({{ $model or '' }}){
				return {{ $model or '' }}.id;
			}).indexOf(data.object.id);
			ctrl.{{ $models or '' }}.splice(position,1);
		});
		
		$scope.$on('$destroy', function(){
			createListener();
			updateListener();
		});
	}
})();