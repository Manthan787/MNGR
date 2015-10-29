(function(){
    angular.module('Settings')
        .controller('StaffController', function($scope, $http, FormHelper, User){

            $scope.newMember = new User;
            $scope.roles = [
                {
                    'id' : 1,
                    'role' : 'Administrator'
                },
                {
                    'id' : 2,
                    'role' : 'Teacher'
                },
                {
                    'id' : 3,
                    'role' : 'Accountant'
                },
            ];

            $scope.checkIfTeacher = function(){
                if($scope.newMember.role_id == 2){
                    $scope.isTeacher = true;
                    FormHelper.getSubjects().then(function(subjects){
                        $scope.subjects = subjects;
                    })
                }
                else
                {
                    $scope.isTeacher = false;
                }
            }

            $scope.add = function(){
                $scope.loading = true;
                $scope.newMember.save().then(function(msg){
                    $scope.success = msg;
                    $scope.newMember = new User;
                    $scope.isTeacher = false;
                    $scope.loading = false;
                }, function(response){
                    $scope.error = response.data;
                });
            }
        });
})();
