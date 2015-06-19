(function(){
    angular.module('adminApp')
        .controller('HomeController', function($scope, $location){

            if(!sessionStorage.authenticated)
            {
                $location.path('/');
            }

    })
    .controller('PanelController', function($scope, $location, Authaid, AuthService){
            $scope.user = {};
            $scope.user.name = Authaid.getName();
            $scope.user.position = Authaid.getPosition();
            $scope.user.isAdmin = Authaid.isAdmin();
            $scope.user.isTeacher = Authaid.isTeacher();
            $scope.user.isAccountant = Authaid.isAccountant();
            $scope.user.isStudent = Authaid.isStudent();

            $scope.logout = function(){
                AuthService.logout().then(function(response){
                    console.log('HERE!');
                    delete sessionStorage.user;
                    delete sessionStorage.authenticated;
                    $scope.user = {};
                    $location.path('/');
                })
            }


        });
})();