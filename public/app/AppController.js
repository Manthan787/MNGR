(function(){
    var app = angular.module('adminApp');
    app.controller('AppController', function($scope, $http, $window){
        $scope.logout = function() {
            $http.get('api/auth/logout').then(function(response){
                delete sessionStorage.authenticated;
                delete sessionStorage.user;
                $window.location.href = '/admin/login';
            }, function(response){
                console.log(response);
            });
        }
    });

})();
