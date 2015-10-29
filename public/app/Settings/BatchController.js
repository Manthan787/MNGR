(function(){
    angular.module('Settings')
        .controller('AddBatchController', function($scope, $http){
            $scope.loading = true;
            $scope.newBatch =  {};
            $http.get('api/Standards/all').then(function(response){
                $scope.standards = response.data;
                $scope.loading = false;
            });
            $scope.days = [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ];
            $scope.newBatch.timings = [
                {'day':'Monday', 'from':'08:30 AM', 'to':'09:30 AM'}
            ];
            $scope.addTiming = function() {
                $scope.newBatch.timings.push({'day':'Monday', 'from':'06:15 PM', 'to':'08:00 PM'});
            };
            $scope.add = function(isValid) {
                $scope.submitted = true;
                if(isValid) {
                    $scope.loading = true;
                    $http.post('api/batches/add', $scope.newBatch).then(function(response){
                        $scope.success = response.data.msg;
                        $scope.submitted = false;
                        $scope.newBatch = {};
                        $scope.newBatch.timings = [{'day':'Monday', 'from':'08:30 AM', 'to':'09:30 AM'}];
                        $scope.addBatchForm.$setPristine();
                        $scope.loading = false;
                    }, function(response){
                        console.log(response)
                        $scope.error = response.data.msg;
                        $scope.loading = false;
                        $scope.submitted = false;
                    });

                }
            }

        });
})();
