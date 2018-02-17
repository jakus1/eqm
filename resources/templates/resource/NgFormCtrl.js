(function(){
	'use strict';
	angular
	.module('myApp')
	.controller('[Model]FormController', [Model]FormController)
	[Model]FormController.$inject = ['$rootScope','$scope', '$http', '$filter' ,'$uibModal', '$uibModalInstance', 'items', 'FileUploadService', '[Model]Service',"$controller"];
		function [Model]FormController($rootScope,$scope, $http, $filter, $uibModal, $uibModalInstance, items, FileUploadService, [Model]Service, $controller){
			
			var ctrl = this;

			//Get the default functionality for modal form
			var base = $controller('BaseFormCtrl', {$scope: $scope});

			angular.extend(this, base);

			if((items != undefined)&&(items.bind != undefined)) {
				ctrl.bind = items.bind;
				ctrl.originalObj = angular.extend({}, items.bind);
			}

			if((items != undefined)&&(items.expect != undefined)) {
				ctrl.expectEvent = items.expect;
			}

			ctrl.add[Model] = function(){
				var data = ctrl.bind
				[Model]Service.add[Model](data)
				.then(function(res){
					ctrl.[models].push(res);
					ctrl.fireEvents(res);
				})
				.catch(function(err){
					console.error("ERROR RESPONDING FROM add[Model]: ", err); 
				});
			}

			ctrl.update[Model]= function(){
				var data = ctrl.bind
				if(ctrl.assigned_parent.originalObject != undefined) {
					data.parent_id = ctrl.assigned_parent.originalObject.id
				}
				[Model]Service.update[Model](ctrl.bind.id, data)
				.then(function(res){
					$uibModalInstance.close(ctrl.bind);
				})
				.catch(function(err){
					console.error("ERROR RESPONDING FROM update[Model]: ", err); 
				});
			}

			ctrl.delete[Model] = function([model]Id, idx){
				var data = ctrl.bind
				[Model]Service.delete[Model]([model]Id)
				.then(function(res){
					ctrl.[models].splice(idx, 1);
					ctrl.fireEvents(res);
				})
				.catch(function(err){
					console.error("ERROR RESPONDING FROM delete[Model]: ", err); 
				});
			}

			ctrl.fireEvents = function(d){
				if(expectEvent != undefined && expectEvent != ''){
					$rootScope.$emit(expectEvent, d);
				}else{
					//
				}
			}

			$scope.ok = ctrl.ok;

			$scope.cancel = function () {
				if(ctrl.bind != undefined) {
					// angular.extend(ctrl.bind, originalObj);
				}
				$uibModalInstance.dismiss('cancel');
			};
	}
})();