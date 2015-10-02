(function(){

    var app = angular.module('Account', []);

    app.controller('AccountSettings', function($scope) {

    })

    app.controller('ChangePassword', function($scope, $http) {

        $scope.changePassword = function(isValid) {

          if(isValid) {
            $scope.$parent.loading = true;
            var data = {
                          'new': $scope.newPassword
                        }
            if($scope.newPassword == $scope.newPasswordAgain) {
              $http.post('api/auth/changePassword', data)
              .then(function(response) {
                  $scope.$parent.success = response.data.msg;
                  $scope.$parent.error = '';
                  $scope.newPassword = '';
                  $scope.newPasswordAgain = '';
                  $scope.changePasswordForm.$setPristine();
                  $scope.$parent.loading = false;
                }, function(response) {
                  $scope.$parent.error = '';
                  $scope.$parent.loading = false;
              })

            }
            else {
              $scope.$parent.success = ''
              $scope.$parent.error = 'Passwords don\'t match. Make sure you type the same password in both the fields. ';
              $scope.$parent.loading = false;
            }
          }
        }

      })


})();
