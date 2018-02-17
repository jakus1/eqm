(function(){
	'use strict';
	angular
	.module('myApp')
	.factory('CommunicationService', CommunicationService)
	CommunicationService.$inject = ['$http']
	function CommunicationService($http){
		var service = {
			getAllCommunicationsByParent:getAllCommunicationsByParent,
			getAllCommunicationsByProperty:getAllCommunicationsByProperty,
			getAllCommunications:getAllCommunications,
			getCommunication:getCommunication,
			addCommunication:addCommunication,
			updateCommunication:updateCommunication,
			deleteCommunication:deleteCommunication
		};
		return service;

		/*##############################################################################################
		methods
		##############################################################################################*/
		
		function getAllCommunicationsByParent(parentId,parentType){
			return $http.get('/api/communications-by-parent/' + parentId + '/' + parentType)
			.then(function(response){
				// console.log("getCommunications RESPONSE: ",response);
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

		function getAllCommunicationsByProperty(propertyName,propertyValue){
			return $http.get('/api/communications-by-property/' + propertyName + '/' + propertyValue)
			.then(function(response){
				// console.log("getCommunications RESPONSE: ",response);
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

		function getAllCommunications(q,count){
			q = q || "";
			count = count || 1000;
			var url = '/api/all-communications';
			if ((count != '')&&(q != '')) {
				url = url + '/' + q + '/' + count;
			}else if (q != '') {
				url = url + '/' + q;
			}
			return $http.get(url)
			.then(function(response){
				// console.log("getCommunications RESPONSE: ",response);
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

		function getCommunication(communicationId){
			return $http.get('/api/communication/' + communicationId)
			.then(function(response){
				// console.log("getCommunications RESPONSE: ",response);
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

		function addCommunication(data){
			return $http.post('/api/communication', data)
			.then(function(response){
				// console.log("addCommunication RESPONSE: ",response);
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

		function updateCommunication(communicationId, data){
			return $http.put('/api/communication/' + communicationId, data)
			.then(function(response){
				// console.log("updateCommunication RESPONSE: ",response);
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

		function deleteCommunication(communicationId, data){
			return $http.delete('/api/communication/' + communicationId)
			.then(function(response){
				// console.log("deleteCommunication RESPONSE: ",response);
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
