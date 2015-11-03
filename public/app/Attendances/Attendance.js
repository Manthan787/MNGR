(function() {
    angular.module('Attendances', ['Utils'])
    .controller('MarkAttendanceController', function($scope, Attendance, Student, Standard) {
        $scope.loading = true
        attendance_init()

        // Load standards for the dropdown menu
        Standard.getAll().then(function(res) {
            if(!res.length) {
                $scope.info = "You have not added any standards yet. Please add standards in the settings section first."
            }
            else {
              $scope.standards = res;
            }
            $scope.loading = false
        }, function(msg) {
            $scope.error = msg
            $scope.loading = false
        })

        // Get the batches under the selected standard
        $scope.getBatches = function(standard) {
            resetStudents()
            $scope.resetFeedback()
            $scope.loading = true
            if(standard.batches[0] != undefined) {
                $scope.hasBatches = true
                $scope.batches = standard.batches
            }
            else {
                $scope.hasBatches = false
                $scope.info = "The standard you've selected does not seem to have any batches. Please create batches in the settings section first."
            }
            $scope.loading = false
        }

        // Get students for the selected batch
        $scope.getStudents = function(batchID) {
            resetStudents()
            $scope.resetFeedback()
            $scope.loading = true
            Student.getByBatch(batchID)
            .then(function(res) {
                if(res.length) {
                  res.forEach(function(student) {
                      student.present = true
                  })
                  $scope.attendance.students = res
                }
                else {
                  $scope.info = "You have not added any students in the selected batch. Please add students in this batch and try again later"
                }
                $scope.loading = false
            })
        }
        
        // Save attendance
        $scope.save = function() {
          $scope.loading = true
          var answer = confirm('Do you want to notify absent students\' parents?')
            $scope.attendance.create(answer)
            .then(function(msg) {
                $scope.success = msg
                attendance_init()
                $scope.loading = false
            }, function(msg) {
                $scope.error = msg
                $scope.loading = false
            })
        }

        $scope.checkAll = function() {
            $scope.attendance.students.forEach(function(student) {
                student.present = true
            })
        }

        $scope.uncheckAll = function() {
            $scope.attendance.students.forEach(function(student) {
                student.present = false
            })
        }


        function attendance_init() {
          $scope.selectedStandard = null
          $scope.attendance = new Attendance();
          $scope.attendance.date = new Date();
        }

        function resetStudents() {
          $scope.attendance.students = null
        }
    })
    .controller('ViewAttendanceController', function($scope) {

    })
})()
