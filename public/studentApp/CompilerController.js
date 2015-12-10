(function() {
    angular.module('desk')
    .controller('CompilerController', function($scope, $http) {
        $scope.output;
        $scope.loading;

        $scope.compile = function() {
            $scope.loading = true;
            $http.post('/api/desk/compiler/compile', $scope.compiler)
            .then(function(response) {
                $scope.output = response.data;
                $scope.loading = false;
            })
        }
    })
})();
