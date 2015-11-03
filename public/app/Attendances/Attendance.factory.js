(function() {
    angular.module('Attendances')
    .factory('Attendance', function($http) {
        var Attendance = function(data) {
            angular.extend(this, data);
        }

        Attendance.prototype.create = function(notify) {
            var attendance = this;

            return $http.post('api/attendances/create?notify='+notify, attendance)
            .then(function(response) {
                return response.data.msg
            }, function(response) {
                return response.data.msg
            })
        }

        return Attendance
    })
})();
