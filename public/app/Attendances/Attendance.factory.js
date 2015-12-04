(function() {
    angular.module('Attendances')
    .factory('Attendance', function($http) {
        var BASE_URL = 'api/attendances'
        var Attendance = function(data) {
            angular.extend(this, data);
        }

        Attendance.prototype.create = function(notify) {
            var attendance = this;

            return $http.post(BASE_URL+'/create?notify='+notify, attendance)
            .then(function(response) {
                return response.data.msg
            }, function(response) {
                return response.data.msg
            })
        }

        Attendance.getAll = function() {
            return $http.get(BASE_URL+'/all')
                   .then(function(response) {
                      return response.data
                   }, function(response) {
                      return response.data.msg
                   })
        }

        return Attendance
    })
})();
