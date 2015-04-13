(function(){
    angular.module('Auth').
        service('AuthService', function($http){

           this.login = function(credentials){
               return $http.post('/api/auth/login', credentials);
           }

           this.logout = function(){
                   return $http.get('api/auth/logout');
           }
        });
})();