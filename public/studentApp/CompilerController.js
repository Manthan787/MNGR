(function() {
    angular.module('desk')
    .controller('CompilerController', function($scope, $http) {
        $scope.output;
        $scope.loading;
        $scope.compiler = {};
        $scope.compiler.language = "c";

        loadDefaultCode();

        $scope.compile = function() {
            $scope.loading = true;
            if($scope.compiler.language =='java' && !$scope.compiler.name) {
                $scope.error = true;
                $scope.loading = false;
            }
            else {
              $scope.error = false;
              $http.post('/api/desk/compiler/compile', $scope.compiler)
              .then(function(response) {
                  $scope.output = response.data;
                  $scope.loading = false;
              })
            }
        }

        $scope.showNameBox = function() {
            if($scope.compiler.language === 'java') return true;
        }

        $scope.clear = function() {
            $scope.output = null;
            $scope.compiler.program = null;
            loadDefaultCode();
        }

        function loadDefaultCode() {
            var language = $scope.compiler.language;
            if(language == "c")
              $scope.compiler.program = '#include<stdio.h>\n\nint main()\n{\n\n\n}';
            else if (language =="java")
              $scope.compiler.program = 'import java.util.*;\n\n class Demo {\n   public static void main(String[] args)\n  {\n\n\n  }\n}';
            else if(language == "cpp")
              $scope.compiler.program = '#include<iostream>\nusing namespace std;\n\nint main()\n{\n\n\n}';

        }
    })
})();
