(function(){
	'use strict';
	angular
	.module('myApp')
	.factory('[Model]Service', [Model]Service)
	[Model]Service.$inject = ['$http']
	function [Model]Service($http){
		return {
			getAll[Models]ByParent: function(parentId,parentType){
				return $http.get('/api/[models]-by-parent/' + parentId + '/' + parentType)
				.then(function(response){
					// console.log("get[Models] RESPONSE: ",response);
					if(response.status == 200){
						return response.data.payload;
					}else{
						console.error("ERROR: ", response); 
					}
				})
				.catch(function(err){
					console.error("SERVICE ERROR(other): ", err); 
					throw err;
				});

			},
			getAll[Models]ByProperty: function(property1Name,property1Value){
				return $http.get('/api/all-[models]-by-property/' + propertyName + '/' + propertyValue)
				.then(function(response){
					// console.log("get[Models] RESPONSE: ",response);
					if(response.status == 200){
						return response.data.payload;
					}else{
						console.error("ERROR: ", response); 
					}
				})
				.catch(function(err){
					console.error("SERVICE ERROR(other): ", err); 
					throw err;
				});

			},
			getAll[Models]: function(q){
				return $http.get('/api/all-[models]/' + q)
				.then(function(response){
					// console.log("get[Models] RESPONSE: ",response);
					if(response.status == 200){
						return {
							data:response.data.payload,
							count:response.data.count
						};
					}else{
						console.error("ERROR: ", response); 
					}
				})
				.catch(function(err){
					console.error("SERVICE ERROR(other): ", err); 
					throw err;
				});

			},
			get[Model]: function([model]Id){
				return $http.get('/api/[model]/' + [model]Id)
				.then(function(response){
					// console.log("get[Models] RESPONSE: ",response);
					if(response.status == 200){
						return response.data.payload;
					}else{
						console.error("ERROR: ", response); 
					}
				})
				.catch(function(err){
					console.error("SERVICE ERROR(other): ", err); 
					throw err;
				});

			},
			add[Model]: function(data){
				return $http.post('/api/[model]', data)
				.then(function(response){
					// console.log("add[Model] RESPONSE: ",response);
					if(response.status == 200){
						return response.data.payload;
					}else{
						console.error("ERROR: ", response); 
					}
				})
				.catch(function(err){
					console.error("SERVICE ERROR(other): ", err); 
					throw err;
				});

			},
			update[Model]: function([model]Id, data){
				return $http.put('/api/[model]/' + [model]Id, data)
				.then(function(response){
					// console.log("update[Model] RESPONSE: ",response);
					if(response.status == 200){
						return response.data.payload;
					}else{
						console.error("ERROR: ", response); 
					}
				})
				.catch(function(err){
					console.error("SERVICE ERROR(other): ", err); 
					throw err;
				});

			},
			delete[Model]: function([model]Id, data){
				return $http.delete('/api/[model]/' + [model]Id)
				.then(function(response){
					// console.log("delete[Model] RESPONSE: ",response);
					if(response.status == 200){
						return response.data.payload;
					}else{
						console.error("ERROR: ", response); 
					}
				})
				.catch(function(err){
					console.error("SERVICE ERROR(other): ", err); 
					throw err;
				});

			},
		}
		
	} 
})();
