(function(){
    angular.module('Auth', []).
        factory('AuthService', function($http){

           var authservice = {}

           authservice.isAuthenticated = function() {
              return sessionStorage.authenticated;
           };

           authservice.isAuthorized = function(authorizedRoles) {
              if(!angular.isArray(authorizedRoles)) {
                  authorizedRoles = [authorizedRoles];
              }
              var User = JSON.parse(sessionStorage.user);
              return (authservice.isAuthenticated() && authorizedRoles.indexOf(User.data.role_id) !== -1 )
           };

           return authservice;
        });
})();
