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
        $scope.studentCount = 0;
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

        $scope.fetchStudents = function(standard) {
            $scope.currentFilter = null;
            if(standard)
            {
              $scope.loading = true;
              $http.get('api/Standards/'+standard.id+'/Students')
              .then(function(response) {
                  $scope.students = response.data;
                  $scope.recepientCount = $scope.studentCount = $scope.students.length;
                  $scope.checkAll($scope.students);

                  if(!$scope.hasRecepients()) {
                    $scope.info = "There are no students in standard " + standard.division +". Add students to this standard and try again later.";
                  }
                  $scope.loading = false;
              }, function(response) {
                  $scope.loading = false;
              });

            }
            else {
              updateRecepients([]);
            }
          }

        $scope.hasStudents = function() {
            return $scope.studentCount > 0;
        }


        $scope.hasRecepients = function() {
            return $scope.recepientCount > 0;
        }

        $scope.hasStreams = function(standard) {
            if(!standard.streams || !standard.streams[0])
              return false

            return true

        }

        $scope.hasBatches = function(standard) {
            if(!standard.batches || !standard.batches[0])
              return false

            return true
        }

        $scope.filterByStream = function(stream) {
          $scope.loading = true;
          if(stream)
          {
            $scope.currentFilter = stream.stream;
            function belongsToStream(student) {
              return student.stream_id === stream.id
            }

            $scope.students = $scope.students.filter(belongsToStream);
            $scope.checkAll($scope.students)
            updateRecepients();
            $scope.loading = false;

          }
          else {
            updateRecepients();
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

            $scope.students = filtered_recepients;
            $scope.checkAll($scope.students)
            updateRecepients();
            $scope.loading = false;
          }
          else {
            updateRecepients($scope.students);
            $scope.loading = false;
          }
        }

        $scope.Send = function(isValid) {
          if(isValid) {
            $scope.loading = true;
            var recepients_msg = {
              'recepients': $scope.recepients,
              'message'   : $scope.Message
            }

            $http.post('api/sms/send', recepients_msg).then(function(response){
                $scope.success = response.data.msg;
                $scope.loading = false;
            }, function(response) {
                $scope.error = response.data.msg;
                $scope.loading = false;
            });
          }
        }

        $scope.resetRecepientList = function() {
          $scope.currentFilter = null;
          $scope.fetchStudents($scope.Standard)
        }

        $scope.checkAll = function(students) {
          angular.forEach(students, function (student) {
            student.selected = true;
          });
          updateRecepients()
        }

        $scope.uncheckAll = function(students) {
          angular.forEach(students, function(student) {
            student.selected = false;
          });
          updateRecepients()
        }

        $scope.studentSelected = function() {
          updateRecepients()
        }

        function updateRecepients() {
          $scope.loading = true;
          $scope.recepients = [];
          $scope.recepientCount = 0;

          for(var i = 0; i < $scope.students.length; i++)
          {
              if($scope.students[i].selected)
                  $scope.recepients.push($scope.students[i])
          }
          $scope.recepientCount = $scope.recepients.length;
          $scope.loading = false;
        }
    });


})();
