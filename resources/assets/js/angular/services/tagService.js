(function(){
	'use strict';
	angular
	.module('myApp')
	.factory('TagService', TagService)
	TagService.$inject = ['$http']
	function TagService($http){
		var service = {
			getAllTagsByParent:getAllTagsByParent,
			getAllTagsByProperty:getAllTagsByProperty,
			getAllTags:getAllTags,
			getTag:getTag,
			addTag:addTag,
			updateTag:updateTag,
			deleteTag:deleteTag
		};
		return service;

		/*##############################################################################################
		methods
		##############################################################################################*/
		
		function getAllTagsByParent(parentId,parentType){
			return $http.get('/api/tags-by-parent/' + parentId + '/' + parentType)
			.then(function(response){
				// console.log("getTags RESPONSE: ",response);
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

		function getAllTagsByProperty(propertyName,propertyValue){
			return $http.get('/api/tags-by-property/' + propertyName + '/' + propertyValue)
			.then(function(response){
				// console.log("getTags RESPONSE: ",response);
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

		function getAllTags(q,count){
			q = q || "";
			count = count || 1000;
			var url = '/api/all-tags';
			if ((count != '')&&(q != '')) {
				url = url + '/' + q + '/' + count;
			}else if (q != '') {
				url = url + '/' + q;
			}
			return $http.get(url)
			.then(function(response){
				// console.log("getTags RESPONSE: ",response);
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

		function getTag(tagId){
			return $http.get('/api/tag/' + tagId)
			.then(function(response){
				// console.log("getTags RESPONSE: ",response);
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

		function addTag(data){
			return $http.post('/api/tag', data)
			.then(function(response){
				// console.log("addTag RESPONSE: ",response);
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

		function updateTag(tagId, data){
			return $http.put('/api/tag/' + tagId, data)
			.then(function(response){
				// console.log("updateTag RESPONSE: ",response);
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

		function deleteTag(tagId, data){
			return $http.delete('/api/tag/' + tagId)
			.then(function(response){
				// console.log("deleteTag RESPONSE: ",response);
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
