(function(){

	var app = angular.module('Services',[]);

	app.service('SchoolFinder',function($http){
		
		return{

			search : function(searchTerm){

				var schools;
				return $http.get('/api/schools/search/'+searchTerm);
			}
		};
	
	});

})();