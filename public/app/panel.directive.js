(function(){
    angular.module('adminApp').directive('panel', function(){

        return{
            restrict: 'E',
            templateUrl:'app/partials/Directives/wrapper.html',
            controller:'PanelController'
        }
    });
})();