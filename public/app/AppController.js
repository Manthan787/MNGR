(function(){
    var app = angular.module('adminApp');
    app.controller('AppController', function($scope, $http, $window){
        $scope.what = "HEY!";
        $scope.logout = function() {
            $http.get('api/auth/logout').then(function(response){
                delete sessionStorage.authenticated;
                $window.location.href = '/login';
            }, function(response){
                console.log(response);
            });
        }
    });

})();