(function(){
	'use strict';
	angular
	.module('myApp')
	.factory('MemberService', MemberService)
	MemberService.$inject = ['$http']
	function MemberService($http){
		var service = {
			getAllMembersByParent:getAllMembersByParent,
			getAllMembersByProperty:getAllMembersByProperty,
			getAllMembers:getAllMembers,
			getMember:getMember,
			addMember:addMember,
			updateMember:updateMember,
			deleteMember:deleteMember
		};
		return service;

		/*##############################################################################################
		methods
		##############################################################################################*/
		
		function getAllMembersByParent(parentId,parentType){
			return $http.get('/api/members-by-parent/' + parentId + '/' + parentType)
			.then(function(response){
				// console.log("getMembers RESPONSE: ",response);
				if(response.status == 200){
					return response.data.payload;
				}else{
					console.error("ERROR, Non-200 status received: ", response); 
				}
			})
			.catch(function(err){
				console.error("ERROR: ", err); 
				throw err;				
			});

		};

		function getAllMembersByProperty(propertyName,propertyValue){
			return $http.get('/api/members-by-property/' + propertyName + '/' + propertyValue)
			.then(function(response){
				// console.log("getMembers RESPONSE: ",response);
				if(response.status == 200){
					return response.data.payload;
				}else{
					console.error("ERROR, Non-200 status received: ", response); 
				}
			})
			.catch(function(err){
				console.error("ERROR: ", err); 
				throw err;				
			});

		};

		function getAllMembers(q,count){
			q = q || "";
			count = count || 1000;
			var url = '/api/all-members';
			if ((count != '')&&(q != '')) {
				url = url + '/' + q + '/' + count;
			}else if (q != '') {
				url = url + '/' + q;
			}
			return $http.get(url)
			.then(function(response){
				// console.log("getMembers RESPONSE: ",response);
				if(response.status == 200){
					return {
						data:response.data.payload,
						count:response.data.count
					};
				}else{
					console.error("ERROR, Non-200 status received: ", response); 
				}
			})
			.catch(function(err){
				console.error("ERROR: ", err); 
				throw err;				
			});

		};

		function getMember(memberId){
			return $http.get('/api/member/' + memberId)
			.then(function(response){
				// console.log("getMembers RESPONSE: ",response);
				if(response.status == 200){
					return response.data.payload;
				}else{
					console.error("ERROR, Non-200 status received: ", response); 
				}
			})
			.catch(function(err){
				console.error("ERROR: ", err); 
				throw err;				
			});

		};

		function addMember(data){
			return $http.post('/api/member', data)
			.then(function(response){
				// console.log("addMember RESPONSE: ",response);
				if(response.status == 200){
					return response.data.payload;
				}else{
					console.error("ERROR, Non-200 status received: ", response); 
				}
			})
			.catch(function(err){
				console.error("ERROR: ", err); 
				throw err;				
			});

		};

		function updateMember(memberId, data){
			return $http.put('/api/member/' + memberId, data)
			.then(function(response){
				// console.log("updateMember RESPONSE: ",response);
				if(response.status == 200){
					return response.data.payload;
				}else{
					console.error("ERROR, Non-200 status received: ", response); 
				}
			})
			.catch(function(err){
				console.error("ERROR: ", err); 
				throw err;				
			});

		};

		function deleteMember(memberId, data){
			return $http.delete('/api/member/' + memberId)
			.then(function(response){
				// console.log("deleteMember RESPONSE: ",response);
				if(response.status == 200){
					return response.data.payload;
				}else{
					console.error("ERROR, Non-200 status received: ", response); 
				}
			})
			.catch(function(err){
				console.error("ERROR: ", err); 
				throw err;				
			});

		};
	} 
})();
