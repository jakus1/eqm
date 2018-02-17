(function(){
	'use strict';
	angular
	.module('myApp')
	.controller('TagCtrl', TagCtrl)
	TagCtrl.$inject = ["$rootScope","$scope","$http","$filter","$uibModal","TagService","$controller"];
	function TagCtrl($rootScope,$scope, $http, $filter, $uibModal, TagService, $controller){
		var ctrl = this;

		//Get the default functionality
		var base = $controller('BaseCtrl', {$scope: $scope});

		angular.extend(this, base)

		ctrl.columns 			= [
			{'class':'col-md-2','field':'tag','title':'Tag'},
			{'class':'col-md-2','field':'taggable','title':'Taggable'},
		];
		ctrl.orderField 		= ctrl.columns[0];
		ctrl.tags			= [];
		ctrl.tag			= {};
		ctrl.isTabulated	= false;


		// get all Tags
		ctrl.getTags = function(){
			TagService.getAllTags(ctrl.searchDB)
			.then(function(res){
				ctrl.tags = res.data;
				ctrl.sortBy(ctrl.orderField.field);
				ctrl.tagCount = res.count;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getTags: ", err); 
			});
		}

		// get all Tags for a specific parent
		ctrl.getTagsModule = function(parentId,parentType){
			ctrl.parentId = parentId;
			ctrl.parentType = parentType;
			TagService.getAllTagsByParent(parentId,parentType)
			.then(function(res){
				ctrl.tags = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getTags: ", err); 
			});
		}

		// get a specific Tag
		ctrl.getTag = function(tagId){
			TagService.getTag(tagId)
			.then(function(res){
				ctrl.tag = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getTags: ", err); 
			});
		}

		// delete a specific Tag
		ctrl.deleteTag= function (tagId, idx){
			if(confirm('Are you sure you want to delete this tag?')){
				TagService.deleteTag(tagId)
				.then(function(res){
					ctrl.tags.splice(idx, 1);
					ctrl.fireEvents(res);
				})
				.catch(function(err){
					console.error("ERROR RESPONDING FROM GET ALL USERS: ", err); 
				});
			}
		}

		// Search all Tags
		ctrl.searchTags = function(){
			TagService.getAllTags(ctrl.searchDB)
			.then(function(res){
				ctrl.tags = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM searchTags: ", err); 
			});
		}

		// Events Listeners
		var createListener = $rootScope.$on('TagCtrl.create', function (event, data) {
			ctrl.tags.push(data.payload);
		});
		var updateListener = $rootScope.$on('TagCtrl.update', function (event, data) {
			var position = ctrl.tags.map(function(tag){
				return tag.id;
			}).indexOf(data.id);
			ctrl.tags[position] = data;
		});
		var deleteListener = $rootScope.$on('TagCtrl.destroy', function (event, data) {
			var position = ctrl.tags.map(function(tag){
				return tag.id;
			}).indexOf(data.object.id);
			ctrl.tags.splice(position,1);
		});
		
		$scope.$on('$destroy', function(){
			createListener();
			updateListener();
		});
	}
})();