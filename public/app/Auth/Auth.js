(function(){
    angular.module('Auth',[]).
        controller('LoginController', function($scope, AuthService, $location) {
            if(sessionStorage.authenticated){
                $location.path('/dashboard');
            }

            $scope.login = function() {
                AuthService.login({
                    'email': $scope.email,
                    'password': $scope.password
                })
                    .then(function (response) {
                        console.log(response);
                        sessionStorage.user = JSON.stringify(response.data.data);
                        sessionStorage.authenticated = true;
                        $location.path('/dashboard');
                    }, function(response){
                        $scope.msg = response.data.msg;
                    });
            }
        });
})();