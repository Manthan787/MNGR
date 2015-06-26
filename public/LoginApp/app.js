(function(){
    var app = angular.module('login',[]);

    app.controller('LoginController', function($scope,$http,$window){
        $scope.login = function() {
            var credentials = {
                'email' : $scope.email,
                'password' : $scope.password
            };
            $http.post('api/auth/login', credentials).then(function (response) {
                console.log(response);
                sessionStorage.user = JSON.stringify(response.data.data);
                sessionStorage.authenticated = true;
                $window.location.href = '/';
            }, function (response) {
                $scope.msg = response.data.msg;
                console.log($scope.msg);
            });
        }
    });
})();