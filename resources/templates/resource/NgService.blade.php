(function(){
	'use strict';
	angular
	.module('myApp')
	.factory('{{ $Model or '' }}Service', {{ $Model or '' }}Service)
	{{ $Model or '' }}Service.$inject = ['$http']
	function {{ $Model or '' }}Service($http){
		var service = {
			getAll{{ $Models or '' }}ByParent:getAll{{ $Models or '' }}ByParent,
			getAll{{ $Models or '' }}ByProperty:getAll{{ $Models or '' }}ByProperty,
			getAll{{ $Models or '' }}:getAll{{ $Models or '' }},
			get{{ $Model or '' }}:get{{ $Model or '' }},
			add{{ $Model or '' }}:add{{ $Model or '' }},
			update{{ $Model or '' }}:update{{ $Model or '' }},
			delete{{ $Model or '' }}:delete{{ $Model or '' }}
		};
		return service;

		/*##############################################################################################
		methods
		##############################################################################################*/
		
		function getAll{{ $Models or '' }}ByParent(parentId,parentType){
			return $http.get('/api/{{ $models or '' }}-by-parent/' + parentId + '/' + parentType)
			.then(function(response){
				// console.log("get{{ $Models or '' }} RESPONSE: ",response);
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

		function getAll{{ $Models or '' }}ByProperty(propertyName,propertyValue){
			return $http.get('/api/{{ $models or '' }}-by-property/' + propertyName + '/' + propertyValue)
			.then(function(response){
				// console.log("get{{ $Models or '' }} RESPONSE: ",response);
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

		function getAll{{ $Models or '' }}(q,count){
			q = q || "";
			count = count || 1000;
			var url = '/api/all-{{ $models or '' }}';
			if ((count != '')&&(q != '')) {
				url = url + '/' + q + '/' + count;
			}else if (q != '') {
				url = url + '/' + q;
			}
			return $http.get(url)
			.then(function(response){
				// console.log("get{{ $Models or '' }} RESPONSE: ",response);
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

		function get{{ $Model or '' }}({{ $model or '' }}Id){
			return $http.get('/api/{{ $model or '' }}/' + {{ $model or '' }}Id)
			.then(function(response){
				// console.log("get{{ $Models or '' }} RESPONSE: ",response);
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

		function add{{ $Model or '' }}(data){
			return $http.post('/api/{{ $model or '' }}', data)
			.then(function(response){
				// console.log("add{{ $Model or '' }} RESPONSE: ",response);
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

		function update{{ $Model or '' }}({{ $model or '' }}Id, data){
			return $http.put('/api/{{ $model or '' }}/' + {{ $model or '' }}Id, data)
			.then(function(response){
				// console.log("update{{ $Model or '' }} RESPONSE: ",response);
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

		function delete{{ $Model or '' }}({{ $model or '' }}Id, data){
			return $http.delete('/api/{{ $model or '' }}/' + {{ $model or '' }}Id)
			.then(function(response){
				// console.log("delete{{ $Model or '' }} RESPONSE: ",response);
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
