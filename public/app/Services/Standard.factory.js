(function(){
    angular.module('Services',[])
    .factory('Standard', function($http) {
          var BASE_URL = 'api/Standards'

          Standard.getAll = function() {
              return $http.get(BASE_URL+'/all')
                     .then(function(response) {
                          return response.data
                     }, function(response) {
                          return response.data.msg
                     })
          }
    })
})()
