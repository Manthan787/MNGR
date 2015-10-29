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
  			},
        template: '<div class="alert alert-danger" ng-show="error">{{ error }}</div>'+
        '<div class="alert alert-success" ng-show="success">{{ success }}</div>'+
        '<div class="alert alert-info" ng-show="info">{{ info }}</div>'
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
