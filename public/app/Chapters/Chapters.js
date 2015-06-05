(function(){
    var app = angular.module('Chapters', []);
    app.controller('ChapterController', function($scope){
        $scope.showChapters = false;
        $scope.chaptersLoading = false;
    });
    app.controller('AddChapterFormController', function($scope, FormHelper, $http, Question, Standard){
        $scope.newChapter = {};
        $scope.$parent.loading = true;
        var resetStates = function() {
            $scope.hasStreams = false;
            $scope.hasSubjects = false;
            $scope.subjectsError = false;
            $scope.$parent.showChapters = false;
        }
        Standard.getAll().then(function(standards){
            $scope.standards = standards;
            $scope.$parent.loading = false;
        });

        $scope.getStreams = function() {
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
        };

        $scope.getSubjects = function(stream) {
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
            });
        };
        $scope.showChapters = function(subjectID) {
            $scope.$parent.chaptersLoading = true;
            $scope.$parent.showChapters = true;
            $http.get("api/Subjects/"+subjectID+"/Chapters").then(function(response){
                $scope.$parent.chapters = response.data;
                if($scope.$parent.chapters[0] != undefined) {
                    $scope.$parent.noChapters = false;
                }
                else {
                    $scope.$parent.noChapters = true;
                }

                $scope.$parent.chaptersLoading = false;
            });
        };

        $scope.addChapter=  function() {
            console.log($scope.newChapter);
            $http.post("api/Chapters/add", $scope.newChapter).then(function(response){
                $scope.$parent.success = response.data.msg;
                $scope.showChapters($scope.newChapter.subject_id);
                $scope.newChapter.title = null;
            }, function(response){
                $scope.$parent.error = response.data;
            });
        }

    });
})();