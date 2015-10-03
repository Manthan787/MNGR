(function(){
    angular.module('adminApp')

    .controller('HomeController', function($scope, $http){
        $http.get('api/Students/activated/recent')
        .then(function(response) {
            $scope.recentlyActivatedStudents = response.data;
            console.log(response.data);
        }, function(response) {
            console.log(response)
        })
    })

    .controller('SMSCtrl', function($scope, $http) {
        $scope.send = function(isValid) {
          $scope.sendForm.$submitted = true;
          if(isValid) {
              $scope.loading = true
              var data = {
                  'number' : $scope.Number,
                  'message'   : $scope.Message
              }
              $http.post('api/sms/quick-send', data)
              .then(function(response) {
                $scope.error = ''
                $scope.success = response.data.msg;
                $scope.reset()
                $scope.loading = false;

              }, function(response) {
                  $scope.error = response.data.msg;
                  $scope.loading = false;
              })
          }
        }

        $scope.reset = function() {
            $scope.Number   = ''
            $scope.Message  = ''
            $scope.sendForm.$setPristine()
        }
    })
})();
