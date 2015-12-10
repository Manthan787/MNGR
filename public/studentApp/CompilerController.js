(function() {
    angular.module('desk')
    .controller('CompilerController', function($scope, $http) {
        $scope.output;

        $scope.compile = function() {
            console.log($scope.compiler)
            $http.post('/api/desk/compiler/compile', $scope.compiler)
            .then(function(response) {
                $scope.output = response.data;
            })
        }
    })
})();
