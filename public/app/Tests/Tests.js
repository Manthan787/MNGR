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

    app.directive('testsPagination', function(){
     return{
        restrict: 'E',
        template: '<ul class="pagination" ng-if="totalPages">'+
          '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getTests(1)">&laquo;</a></li>'+
          '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getTests(currentPage-1)">&lsaquo; Prev</a></li>'+
          '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
              '<a href="javascript:void(0)" ng-click="getTests(i)">{{i}}</a>'+
          '</li>'+
          '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getTests(currentPage+1)">Next &rsaquo;</a></li>'+
          '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getTests(totalPages)">&raquo;</a></li>'+
        '</ul>'
     };
   });

   app.directive('testCard', function() {
     return {
        restrict: 'E',
        template: '<div class="custom-box-material palette-white">'+
            '<div class="controls">'+
                '<button class="btn btn-danger btn-circle btn-outline" ng-click="delete(test.id)"><i class="glyphicon glyphicon-remove"></i></button>'+
            '</div>'+
            '<a href="/tests/{{ test.id }}/show">'+
              '<h3>{{ test.name }}</h3>'+
            '</a>'+
            '<div class="meta">'+
                '<a href="/tests/{{ test.id }}/show" class="tag label label-warning">'+
                  '<i class="glyphicon glyphicon-list-alt"></i>'+
                  'Question Paper'+
                '</a>'+
                '<a href="/tests/{{ test.id }}/answers" class="tag label label-success">'+
                  '<i class="glyphicon glyphicon-check"></i>'+
                  'Answer Sheet'+
                '</a>'+
                '<span class="tag label label-info pull-right">{{ test.subject.name }}</span>'+
                '<span class="tag label label-primary pull-right">Marks: {{ test.marks }}</span>'+
            '</div>'+
        '</div>'
     }
   })

   app.controller('AllTestsController', function($scope, $http) {
      $scope.tests = []
      $scope.currentPage = 1;
      $scope.totalPages = 0;
      $scope.range = [];

      $scope.getTests = function(pageNumber){

        if(pageNumber===undefined){
          pageNumber = '1';
        }
        $http.get('/api/tests/all?page='+pageNumber).success(function(response) {
          if(response.total) {
            $scope.tests        = response.data;
            $scope.totalPages   = response.last_page;
            $scope.currentPage  = response.current_page;
            var pages = [];

            for(var i=1;i<=response.last_page;i++) {
              pages.push(i);
            }

            $scope.range = pages;
          }
          else {
            $scope.info = "There are no Tests to display. Create a test first and then visit this page again.";
            $scope.tests = []
            $scope.totalPages = 0
            $scope.error = $scope.success = ''
          }

        });

      };

      $scope.delete = function(testID) {
        $scope.loading = true;
        $http.delete('/api/tests/'+testID+'/delete').success(function(response) {
            $scope.getTests($scope.currentPage);
            $scope.success = response.msg;
            $scope.loading = false;
        })
      }

   })

})();
