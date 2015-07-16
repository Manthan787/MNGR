(function(){
    angular.module('Materials', [])
        .controller("MaterialsController", function(){

        })
        .controller('AddMaterialController', function($scope, Standard, FormHelper, $http){
            $scope.newMaterial = {};
            var ck = CKEDITOR.replace('question',{
                'extraPlugins': 'pastefromword,oembed,widget',
                'height': '500px'
            });
            ck.on('pasteState',function(){
                var elm = document.getElementById('AddForm');
                var scope = angular.element(elm).scope();
                scope.$apply(function(){
                    $scope.newMaterial.text = ck.getData();
                });
            });
            $scope.loading = true;
            var resetStates = function() {
                $scope.hasStreams = false;
                $scope.hasSubjects = false;
                $scope.subjectsError = false;
                $scope.hasChapters = false;
            }
            Standard.getAll().then(function(standards){
                $scope.standards = standards;
                $scope.loading = false;
            });

            $scope.getStreams = function() {
                $scope.loading = true;
                resetStates();
                $scope.streams = FormHelper.loadStreams($scope.selectedStandard);
                if($scope.streams)
                {
                    $scope.hasStreams = true;
                }
                else
                {
                    $scope.hasStreams = false;
                    $scope.subjects = FormHelper.getSubjectsByStd($scope.selectedStandard.id, $scope.standards);
                    $scope.hasSubjects = true;
                }
                $scope.loading = false;
            };

            $scope.getSubjects = function(stream) {
                $scope.loading = true;
                FormHelper.getSubjectsByStream(stream.id).then(function (subjects) {
                    $scope.subjects = subjects;
                    if ($scope.subjects[0] != undefined) {
                        $scope.hasSubjects = true;
                        $scope.subjectsError = false;
                    }
                    else {
                        $scope.hasSubjects = false;
                        $scope.subjectsError = true;
                    }
                    $scope.loading = false;
                });
            };
            $scope.getChapters = function(subject) {
                $scope.loading = true;
                $http.get("api/Subjects/"+subject.id+"/Chapters").then(function(response){
                    $scope.chapters = response.data;
                    if($scope.chapters[0] != undefined) {
                        $scope.hasChapters = true;
                    }
                    $scope.loading = false;
                });
            };

            $scope.addMaterial = function() {
                $http.post('api/materials/add', $scope.newMaterial).then(function(response){
                    $scope.$parent.success = response.data.msg;
                    resetStates();
                    $scope.newMaterial = {};
                    ck.setData('');
                }, function(response){
                    console.log(response);
                });
            }
        });
})();
