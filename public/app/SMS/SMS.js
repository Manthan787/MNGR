(function(){
    var app = angular.module('SMS', []);

    app.controller('SMSController', function($scope, Standard, Student, $http) {
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

        $scope.RecepientTypes = [
          {"id": 1, "type": "Notify Students"},
          {"id": 2, "type": "Notify Parents"}, // This is the default recepient type
          {"id": 3, "type": "Notify both Students & Parents"}
        ];

        $scope.setRecepientType = function(typeID) {
          for(var i = 0; i < $scope.RecepientTypes.length; i++)
          {
            if($scope.RecepientTypes[i].id === typeID)
                $scope.currentRecepientType = $scope.RecepientTypes[i];
          }

        }

        $scope.setRecepientType(2);

        $scope.standardSelected = function(standard) {
            $scope.currentFilter = null;
            if(standard)
            {
              $scope.error = "";
              $scope.loading = true;
              $http.get('api/Standards/'+standard.id+'/Students')
              .then(function(response) {
                  $scope.students = response.data;
                  $scope.recepients = response.data;
                  $scope.recepientCount = $scope.recepients.length;

                  if(!$scope.hasRecepients()) {
                    $scope.error = "There are no students in standard " + standard.division +". Add students to this standard and try again later.";
                  }
                  $scope.loading = false;
              }, function() {
                  console.log("ERROR!");
                  $scope.loading = false;
              });

            }
            else {
              $scope.error = '';
              updateRecepients([]);
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


        $scope.filterByStream = function(stream) {
          $scope.loading = true;
          if(stream)
          {
            $scope.currentFilter = stream.stream;
            function belongsToStream(student) {
              return student.stream_id === stream.id
            }

            filtered_recepients = $scope.students.filter(belongsToStream);
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
            $scope.currentFilter = batch.name;

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
          if(isValid) {
            var recepients_msg = {
              'recepients': $scope.recepients,
              'message'   : $scope.Message
            }
            console.log(recepients_msg);
            $http.post('api/sms/send', recepients_msg).then(function(response){
                $scope.success = response.data.msg;
            }, function(response) {
                console.log(response);
                $scope.error = response.data.msg;
            });
          }
        }

        $scope.resetRecepientList = function() {
          $scope.currentFilter = null;
          updateRecepients($scope.students);
        }

        $scope.checkAll = function() {
          angular.forEach($scope.recepients, function (recepient) {
            recepient.selected = true;
          });
        }

        $scope.uncheckAll = function() {
          angular.forEach($scope.recepients, function(recepient) {
            recepient.selected = false;
          });
        }

        $scope.remove = function() {

          $scope.recepients = $scope.recepients.filter(function(recepient) {
              return !recepient.selected
          })

          $scope.recepientCount = $scope.recepients.length;
        }

        function updateRecepients(newRecepients) {
          $scope.recepients = newRecepients;
          $scope.recepientCount = $scope.recepients.length;
        }


    });


})();
