(function(){
    var app = angular.module('SMS', []);

    app.controller('SMSController', function($scope, Standard, $http) {
        // bootstrap the page
        $scope.loading = true;
        Standard.getAll().then(function(standards) {
            $scope.standards = standards;
            $scope.loading = false;
        });
        // Functionality
        $scope.recepientCount = 0;
        $scope.displayStreamsOption = false;
        $scope.displayBatchesOption = false;

        $scope.standardSelected = function(standard) {
            if(standard)
            {
              $scope.loading = true;
              $http.get('api/Standards/'+standard.id+'/Students')
              .then(function(response) {
                  $scope.students = response.data;
                  $scope.recepients = response.data;
                  $scope.recepientCount = $scope.recepients.length;
                  $scope.loading = false;
              }, function() {
                  console.log("ERROR!");
                  $scope.loading = false;
              });

            }
          }


        $scope.hasRecepients = function() {
          if($scope.recepientCount > 0)
          {
            return true;
          }
            return false;
        }

        $scope.hasStreams = function(standard) {
            if(!standard.streams || !standard.streams[0] )
            {
              return false;
            }
              return true;
        }

        $scope.hasBatches = function(standard) {
            if(!standard.batches || !standard.batches[0] )
            {
              return false;
            }
              return true;
        }

        $scope.showFilter = function(standard) {
            if(!$scope.hasStreams(standard) && !$scope.hasBatches(standard))
            {
              return false;
            }
              return true;
        }

        $scope.loadFilters = function(filter) {
          $scope.loading = true;

          if(filter === 'filter_by_stream') {
            $scope.displayStreamsOption = true;
            $scope.displayBatchesOption = false;
          }
          else if(filter === 'filter_by_batch') {
            $scope.displayStreamsOption = false;
            $scope.displayBatchesOption = true;
          }
          else if(filter === 'filter_by_both') {
            resetFilterVariables();
            $scope.displayStreamsOption = true;
            $scope.displayBatchesOption = true;
          }
          else {
            $scope.displayStreamsOption = false;
            $scope.displayBatchesOption = false;
          }
          updateRecepients($scope.students);
          $scope.loading = false;
        }


        $scope.filterByStream = function(stream) {
          $scope.loading = true;
          if(stream)
          {
            var filtered_recepients = [];
            for(var i = 0; i < $scope.students.length; i++)
            {
              if($scope.students[i].stream_id == stream.id)
              {
                filtered_recepients.push($scope.students[i]);
              }
            }
            updateRecepients(filtered_recepients);
            $scope.loading = false;
          }
          else {
            updateRecepients($scope.students);
            $scope.loading = false;
          }
        }

        $scope.filterByBatch = function(batch) {
          $scope.loading = true;
          if(batch)
          {
            var filtered_recepients = [];
            for(var i = 0; i < $scope.students.length; i++)
            {
              var student = $scope.students[i];
              if(student.batches && student.batches[0])
              {
                for(var j = 0; j < student.batches.length; j++)
                {
                  if(student.batches[j].id === batch.id)
                  {
                    filtered_recepients.push(student);
                  }
                }
              }
            }
            updateRecepients(filtered_recepients);
            $scope.loading = false;
          }
          else {
            updateRecepients($scope.students);
            $scope.loading = false;
          }
        }


        $scope.Send = function(isValid) {
          alert(isValid);
        }

        function updateRecepients(newRecepients) {
          $scope.recepients = newRecepients;
          $scope.recepientCount = $scope.recepients.length;
        }

        function resetFilterVariables() {
          $scope.Stream = {};
          $scope.Batch = {};
        }

    });


})();
