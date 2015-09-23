(function(){
    var app = angular.module('login',[]);

    app.controller('LoginController', function($scope,$http,$window){
        if(sessionStorage.authenticated) {
            $window.location.href = '/#/';
        }
        $scope.login = function() {
            var credentials = {
                'email' : $scope.email,
                'password' : $scope.password
            };
            $http.post('/api/auth/login', credentials).then(function (response) {
                sessionStorage.authenticated = true;
                $window.location.href = '/admin';
            }, function (response) {
                $scope.msg = response.data.msg;
            });
        }


    });
})();
