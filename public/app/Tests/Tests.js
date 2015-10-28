(function(){
    var app = angular.module('Tests', []);

    app.controller('TestController', function($scope){

    });

    app.controller('CreateTestController', function($scope, $http, $window) {
        $scope.loading = true;
        $http.get('api/Subjects/all').then(function(response){
            $scope.subjects = response.data;
            $scope.loading = false;
        });

        $scope.getChapters = function(subjectID) {
            $scope.loading = true;
            $scope.chapters = {};
            for(var i = 0; i<$scope.subjects.length; i++)
            {
                if($scope.subjects[i].id == subjectID)
                {
                    $scope.chapters = $scope.subjects[i].chapters;
                }
            }
            if($scope.chapters && $scope.chapters[0] != null)
            {
                $scope.hasChapters = true;
                $scope.noChaptersError = false;
            }
            else {
                $scope.hasChapters = false;
                $scope.noChaptersError = true;
            }

        }

        $scope.createTest = function(isValid){
            $scope.submitted = true;
            $scope.loading = true;
            if(isValid){
                $scope.newTest.is_online = 0;
                $http.post('api/tests/create',$scope.newTest).then(function(response){
                    console.log(response.data);
                    $scope.questions = response.data.questions;
                    $scope.$parent.error = null;
                    $scope.$parent.success = response.data.msg;
                    $scope.submitted = false;
                    $scope.newTest = {}
                    $scope.newTest.layout = "horizontal"
                    $scope.hasChapters = false;
                    $scope.loading = false;
                    $scope.$parent.success = "Redirecting To Test Paper";
                    $window.location.href = response.data.redirect 
                },function(response){
                    $scope.$parent.success = null;
                    $scope.$parent.error = response.data.msg;
                    $scope.loading = false;
                });

                $scope.submitted = false;
                $scope.createTestForm.$setPristine();
            }
        }
    })

})();
