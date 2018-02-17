(function(){
	'use strict';
	angular
	.module('myApp')
	.factory('MessageService', MessageService)
	MessageService.$inject = ['$http']
	function MessageService($http){
		var service = {
			getAllMessagesByParent:getAllMessagesByParent,
			getAllMessagesByProperty:getAllMessagesByProperty,
			getAllMessages:getAllMessages,
			getMessage:getMessage,
			addMessage:addMessage,
			updateMessage:updateMessage,
			deleteMessage:deleteMessage
		};
		return service;

		/*##############################################################################################
		methods
		##############################################################################################*/
		
		function getAllMessagesByParent(parentId,parentType){
			return $http.get('/api/messages-by-parent/' + parentId + '/' + parentType)
			.then(function(response){
				// console.log("getMessages RESPONSE: ",response);
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

		function getAllMessagesByProperty(propertyName,propertyValue){
			return $http.get('/api/messages-by-property/' + propertyName + '/' + propertyValue)
			.then(function(response){
				// console.log("getMessages RESPONSE: ",response);
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

		function getAllMessages(q,count){
			q = q || "";
			count = count || 1000;
			var url = '/api/all-messages';
			if ((count != '')&&(q != '')) {
				url = url + '/' + q + '/' + count;
			}else if (q != '') {
				url = url + '/' + q;
			}
			return $http.get(url)
			.then(function(response){
				// console.log("getMessages RESPONSE: ",response);
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

		function getMessage(messageId){
			return $http.get('/api/message/' + messageId)
			.then(function(response){
				// console.log("getMessages RESPONSE: ",response);
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

		function addMessage(data){
			return $http.post('/api/message', data)
			.then(function(response){
				// console.log("addMessage RESPONSE: ",response);
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

		function updateMessage(messageId, data){
			return $http.put('/api/message/' + messageId, data)
			.then(function(response){
				// console.log("updateMessage RESPONSE: ",response);
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

		function deleteMessage(messageId, data){
			return $http.delete('/api/message/' + messageId)
			.then(function(response){
				// console.log("deleteMessage RESPONSE: ",response);
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
