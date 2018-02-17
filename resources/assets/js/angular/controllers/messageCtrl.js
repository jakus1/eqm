(function(){
	'use strict';
	angular
	.module('myApp')
	.controller('MessageCtrl', MessageCtrl)
	MessageCtrl.$inject = ["$rootScope","$scope","$http","$filter","$uibModal","MessageService","$controller"];
	function MessageCtrl($rootScope,$scope, $http, $filter, $uibModal, MessageService, $controller){
		var ctrl = this;

		//Get the default functionality
		var base = $controller('BaseCtrl', {$scope: $scope});

		angular.extend(this, base)

		ctrl.columns 			= [
			{'class':'col-md-2','field':'body','title':'Body'},
		];
		ctrl.orderField 		= ctrl.columns[0];
		ctrl.messages			= [];
		ctrl.message			= {};
		ctrl.isTabulated	= false;


		// get all Messages
		ctrl.getMessages = function(){
			MessageService.getAllMessages(ctrl.searchDB)
			.then(function(res){
				ctrl.messages = res.data;
				ctrl.sortBy(ctrl.orderField.field);
				ctrl.messageCount = res.count;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getMessages: ", err); 
			});
		}

		// get all Messages for a specific parent
		ctrl.getMessagesModule = function(parentId,parentType){
			ctrl.parentId = parentId;
			ctrl.parentType = parentType;
			MessageService.getAllMessagesByParent(parentId,parentType)
			.then(function(res){
				ctrl.messages = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getMessages: ", err); 
			});
		}

		// get a specific Message
		ctrl.getMessage = function(messageId){
			MessageService.getMessage(messageId)
			.then(function(res){
				ctrl.message = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getMessages: ", err); 
			});
		}

		// delete a specific Message
		ctrl.deleteMessage= function (messageId, idx){
			if(confirm('Are you sure you want to delete this message?')){
				MessageService.deleteMessage(messageId)
				.then(function(res){
					ctrl.messages.splice(idx, 1);
					ctrl.fireEvents(res);
				})
				.catch(function(err){
					console.error("ERROR RESPONDING FROM GET ALL USERS: ", err); 
				});
			}
		}

		// Search all Messages
		ctrl.searchMessages = function(){
			MessageService.getAllMessages(ctrl.searchDB)
			.then(function(res){
				ctrl.messages = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM searchMessages: ", err); 
			});
		}

		// Events Listeners
		var createListener = $rootScope.$on('MessageCtrl.create', function (event, data) {
			ctrl.messages.push(data.payload);
		});
		var updateListener = $rootScope.$on('MessageCtrl.update', function (event, data) {
			var position = ctrl.messages.map(function(message){
				return message.id;
			}).indexOf(data.id);
			ctrl.messages[position] = data;
		});
		var deleteListener = $rootScope.$on('MessageCtrl.destroy', function (event, data) {
			var position = ctrl.messages.map(function(message){
				return message.id;
			}).indexOf(data.object.id);
			ctrl.messages.splice(position,1);
		});
		
		$scope.$on('$destroy', function(){
			createListener();
			updateListener();
		});
	}
})();