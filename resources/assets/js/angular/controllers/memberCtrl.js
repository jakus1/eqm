(function(){
	'use strict';
	angular
	.module('myApp')
	.controller('MemberCtrl', MemberCtrl)
	MemberCtrl.$inject = ["$rootScope","$scope","$http","$filter","$uibModal","MemberService","$controller"];
	function MemberCtrl($rootScope,$scope, $http, $filter, $uibModal, MemberService, $controller){
		var ctrl = this;

		//Get the default functionality
		var base = $controller('BaseCtrl', {$scope: $scope});

		angular.extend(this, base)

		ctrl.columns 			= [
			{'class':'col-md-2','field':'first','title':'First'},
			{'class':'col-md-2','field':'last','title':'Last'},
			{'class':'col-md-2','field':'email','title':'Email'},
			{'class':'col-md-2','field':'sms_phone','title':'Sms phone'},
			{'class':'col-md-2','field':'description','title':'Description'},
		];
		ctrl.orderField 		= ctrl.columns[0];
		ctrl.members			= [];
		ctrl.member			= {};
		ctrl.isTabulated	= false;


		// get all Members
		ctrl.getMembers = function(){
			MemberService.getAllMembers(ctrl.searchDB)
			.then(function(res){
				ctrl.members = res.data;
				ctrl.sortBy(ctrl.orderField.field);
				ctrl.memberCount = res.count;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getMembers: ", err); 
			});
		}

		// get all Members for a specific parent
		ctrl.getMembersModule = function(parentId,parentType){
			ctrl.parentId = parentId;
			ctrl.parentType = parentType;
			MemberService.getAllMembersByParent(parentId,parentType)
			.then(function(res){
				ctrl.members = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getMembers: ", err); 
			});
		}

		// get a specific Member
		ctrl.getMember = function(memberId){
			MemberService.getMember(memberId)
			.then(function(res){
				ctrl.member = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM getMembers: ", err); 
			});
		}

		// delete a specific Member
		ctrl.deleteMember= function (memberId, idx){
			if(confirm('Are you sure you want to delete this member?')){
				MemberService.deleteMember(memberId)
				.then(function(res){
					ctrl.members.splice(idx, 1);
					ctrl.fireEvents(res);
				})
				.catch(function(err){
					console.error("ERROR RESPONDING FROM GET ALL USERS: ", err); 
				});
			}
		}

		// Search all Members
		ctrl.searchMembers = function(){
			MemberService.getAllMembers(ctrl.searchDB)
			.then(function(res){
				ctrl.members = res;
				ctrl.isLoaded = true;
			})
			.catch(function(err){
				console.error("ERROR RESPONDING FROM searchMembers: ", err); 
			});
		}

		// Events Listeners
		var createListener = $rootScope.$on('MemberCtrl.create', function (event, data) {
			ctrl.members.push(data.payload);
		});
		var updateListener = $rootScope.$on('MemberCtrl.update', function (event, data) {
			var position = ctrl.members.map(function(member){
				return member.id;
			}).indexOf(data.id);
			ctrl.members[position] = data;
		});
		var deleteListener = $rootScope.$on('MemberCtrl.destroy', function (event, data) {
			var position = ctrl.members.map(function(member){
				return member.id;
			}).indexOf(data.object.id);
			ctrl.members.splice(position,1);
		});
		
		$scope.$on('$destroy', function(){
			createListener();
			updateListener();
		});
	}
})();