(function() {
    var app = angular.module('Utils', []);

    app.directive('feedback', function() {
  		return {
  			restrict: 'E',
  			controller: function($scope, $attrs) {
  					$scope.$watch('error', function(newVal, oldVal) {
  							$scope.success = ''
                $scope.info    = ''
  					})

  					$scope.$watch('success', function(newVal, oldVal) {
  							$scope.error  = ''
                $scope.info   = ''
  					})

            $scope.$watch('info', function(newVal, oldVal) {
  							$scope.error  = ''
                $scope.success   = ''
  					})
            // Resets feedbacks incase any of them are set. Helps removing the alert!
            $scope.resetFeedback = function() {
                $scope.error = $scope.success = $scope.info = ''
            }
  			},
        template: '<div class="alert alert-danger" ng-show="error"><button class="glyphicon glyphicon-remove pull-right" ng-click="resetFeedback()"></button>{{ error }}</div>'+
        '<div class="alert alert-success" ng-show="success"><button class="glyphicon glyphicon-remove pull-right" ng-click="resetFeedback()"></button>{{ success }}</div>'+
        '<div class="alert alert-info" ng-show="info"><button class="glyphicon glyphicon-remove pull-right" ng-click="resetFeedback()"></button>{{ info }}</div>'
  		}
  	})

    app.directive('loading', function() {
        return {
            restrict: 'E',
            controller: function($scope, $attrs) {

            },
            template: '<div align="center" ng-show="loading">'+
                '<img src="app/admin/img/loader.gif" height="45" width="45">'+
            '</div>'
        }
    })

})()
