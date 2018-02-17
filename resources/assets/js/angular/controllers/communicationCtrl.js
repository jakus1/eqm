(function(){
	'use strict';
	angular
	.module('myApp')
	.controller('CommunicationCtrl', CommunicationCtrl)
	CommunicationCtrl.$inject = ["$rootScope","$scope","$http","$filter","$uibModal","CommunicationService","$controller"];
	function CommunicationCtrl($rootScope,$scope, $http, $filter, $uibModal, CommunicationService, $controller){
		var ctrl = this;

		//Get the default functionality
		var base = $controller('BaseCtrl', {$scope: $scope});

		angular.extend(this, base)

		ctrl.columns 			= [
			{'class':'col-md-2','field':'body','title':'Body'},
		];
		ctrl.orderField 		= ctrl.columns[0];
		ctrl.communications			= [];
		ctrl.communication			= {};
		ctrl.isTabulated	= false;


		// get all Communications
		ctrl.getCommunications = function(){
			CommunicationService.getAllCommunications(ctrl.searchDB)
			.then(function(res){
				ctrl.communications = res.data;
				ctrl.sortBy(ctrl.orderField.field);
				ctrl.communicationCount = res.count;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getCommunications: ", err); 
			});
		}

		// get all Communications for a specific parent
		ctrl.getCommunicationsModule = function(parentId,parentType){
			ctrl.parentId = parentId;
			ctrl.parentType = parentType;
			CommunicationService.getAllCommunicationsByParent(parentId,parentType)
			.then(function(res){
				ctrl.communications = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getCommunications: ", err); 
			});
		}

		// get a specific Communication
		ctrl.getCommunication = function(communicationId){
			CommunicationService.getCommunication(communicationId)
			.then(function(res){
				ctrl.communication = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getCommunications: ", err); 
			});
		}

		// delete a specific Communication
		ctrl.deleteCommunication= function (communicationId, idx){
			if(confirm('Are you sure you want to delete this communication?')){
				CommunicationService.deleteCommunication(communicationId)
				.then(function(res){
					ctrl.communications.splice(idx, 1);
					ctrl.fireEvents(res);
				})
				.catch(function(err){
					console.error("ERROR RESPONDING FROM GET ALL USERS: ", err); 
				});
			}
		}

		// Search all Communications
		ctrl.searchCommunications = function(){
			CommunicationService.getAllCommunications(ctrl.searchDB)
			.then(function(res){
				ctrl.communications = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM searchCommunications: ", err); 
			});
		}

		// Events Listeners
		var createListener = $rootScope.$on('CommunicationCtrl.create', function (event, data) {
			ctrl.communications.push(data.payload);
		});
		var updateListener = $rootScope.$on('CommunicationCtrl.update', function (event, data) {
			var position = ctrl.communications.map(function(communication){
				return communication.id;
			}).indexOf(data.id);
			ctrl.communications[position] = data;
		});
		var deleteListener = $rootScope.$on('CommunicationCtrl.destroy', function (event, data) {
			var position = ctrl.communications.map(function(communication){
				return communication.id;
			}).indexOf(data.object.id);
			ctrl.communications.splice(position,1);
		});
		
		$scope.$on('$destroy', function(){
			createListener();
			updateListener();
		});
	}
})();