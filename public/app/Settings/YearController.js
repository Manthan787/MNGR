(function() {
    var app = angular.module('Settings');

    app.controller('YearController', function($scope, $http){
        $scope.error = false;
        $scope.success = false;
        $scope.loading = false;
        $scope.newYear = {};
        $scope.newYear.isCurrent = false;
        $scope.submitted = false;

        var fetchYears = function() {
            $scope.loading = true;
            $http.get('api/years/all').then(function(response) {
                $scope.existingYears = response.data;
                $scope.noYearsError = null;
                $scope.loading = false;
            }, function(response) {
                $scope.noYearsError = response.data.msg;
                $scope.loading = false;
            });

        }

        var reset = function() {
            $scope.newYear = {};
            $scope.selectedYear = null;
            $scope.newYear.isCurrent = false;
        }
        fetchYears();
        var years = [];
        for(var i=1990; i<=2050; i++) {
            years.push(i);
        }
        $scope.years = years;
        $scope.increment = function(year) {
            return ++year;
        }

        $scope.populateText = function (year) {
            if(!year){
                $scope.newYear.year = null;
            }
            else {
                $scope.newYear.year = year + " - "+(++year);
            }

        }

        $scope.showDialog = function() {
            if($scope.newYear.isCurrent == true) {
                var ans = confirm("All the upcoming student entries will be linked with this financial year if you choose it as a current financial year.");
                if (ans == true) {
                    $scope.newYear.isCurrent = true;
                }
                else {
                    $scope.newYear.isCurrent = false;
                }
            }
        }

        $scope.add = function(isValid) {
            $scope.submitted = true;
            if(isValid) {
                $scope.loading = true;
                $scope.newYear.start = $scope.selectedYear;
                $scope.newYear.end = ++$scope.selectedYear;
                console.log($scope.newYear);
                $http.post('api/years/add', $scope.newYear).then(function(response){
                    $scope.success = response.data.msg;
                    $scope.error = false;
                    reset();
                    fetchYears();
                    $scope.loading = false;
                    $scope.submitted = false;
                    $scope.addYearForm.$setPristine();

                }, function(response){
                    $scope.error = response.data.msg;
                    $scope.success = false;
                    $scope.loading = false;
                });
            }
        }

        var editableYear;
        $scope.enableEditableYear = function(yearID) {
            editableYear = yearID;
        }

        $scope.isEditableYear = function(yearID) {
            if(editableYear == yearID) {
                return true;
            }
            else {
                return false;
            }
        }
        $scope.disableEdit = function(yearID) {
            editableYear = null;
        }

        $scope.edit = function(year) {
            $scope.loading = true;
            $http.post('api/years/'+year.id+'/edit',year).then(function(response){
                fetchYears();
                $scope.success = response.data.msg;
                $scope.loading = false;
                $scope.disableEdit(year.id);
            }, function(){
                $scope.error = response.data.msg;
                $scope.loading = false;

            });
        }

        $scope.delete = function(year) {
            var ans = confirm("Deleting this year will result in deletion of all the Students associated with it. Are you sure you want to perform this task?");
            if(ans == true) {
                $scope.loading = true;
                $http.get('api/years/' + year.id + '/delete').then(function (response) {
                    $scope.success = response.data.msg;
                    fetchYears();
                    $scope.loading = false;
                }, function (response) {
                    $scope.error = response.data.msg;
                    $scope.loading = false;
                });
            }
        }
    });
})();