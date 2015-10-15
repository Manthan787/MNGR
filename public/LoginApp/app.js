(function(){
    var app = angular.module('login',['Auth']);

    app.controller('LoginController', function($scope,$http,$window, AuthService){

        if(AuthService.isAuthenticated()) {
            $window.location.href = '/admin#/';
        }

        $scope.login = function() {
            $scope.loading = true;
            $scope.msg = '';
            var credentials = {
                'email' : $scope.email,
                'password' : $scope.password
            };

            $http.post('/api/auth/login', credentials).then(function (response) {
                sessionStorage.authenticated = true;
                sessionStorage.user = JSON.stringify(response.data);
                $window.location.href = '/admin';
                $scope.loading = false;
            }, function (response) {
                $scope.msg = response.data.msg;
                $scope.loading = false;
            });
        }


    });
})();
