(function(){
    var app = angular.module('Chapters', []);
    app.controller('ChapterController', function($scope, FormHelper){
        $scope.showChapters = false;
        $scope.chaptersLoading = false;
        $scope.loading = true;
        FormHelper.getSubjects().then(function(subjects){
            $scope.subjects = subjects;
            $scope.loading = false;
        })
        var editableID;
        $scope.isEditable = function(chapterID) {
            return (editableID == chapterID) ? true : false;
        }
        $scope.enableEditableChapter = function(chapterID) {
            editableID = chapterID;
        }
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
        Standard.getAll().then(function(standards) {
            $scope.standards = standards;
            $scope.$parent.loading = false;
        });

        $scope.getStreams = function() {
            $scope.$parent.loading = true;
            resetStates();
            $scope.streams = FormHelper.loadStreams($scope.selectedStandard);
            if($scope.streams)
            {
                $scope.hasStreams = true;
            }
            else
            {

                if($scope.streams !== null) {
                    $scope.hasStreams = false;
                    $scope.subjects = FormHelper.getSubjectsByStd($scope.selectedStandard.id, $scope.standards);
                    $scope.hasSubjects = true;
                }
            }
            $scope.$parent.loading = false;
        };

        $scope.getSubjects = function(stream) {
            $scope.$parent.loading = true;
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
                $scope.$parent.loading = false;
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

        $scope.addChapter=  function(isValid) {
            $scope.submitted = true;
            $scope.$parent.loading = true;
            if(isValid) {
                $http.post("api/Chapters/add", $scope.newChapter).then(function (response) {
                    $scope.$parent.success = response.data.msg;
                    $scope.showChapters($scope.newChapter.subject_id);
                    $scope.newChapter.title = null;
                    resetStates();
                    $scope.newChapter = false;
                    $scope.submitted = false;
                    $scope.addChapterForm.$setPristine();
                    $scope.$parent.loading = false;
                }, function (response) {
                    $scope.$parent.loading = false;
                    $scope.$parent.error = response.data;
                });
            }
            else {
                $scope.$parent.loading = false;
            }
        }

    });
})();