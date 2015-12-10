(function(){
    angular.module('desk')
        .controller('StudyController', function($scope, $http, $sce) {
            $scope.loading = true;
            $scope.showTopics = false;
            $scope.pointer = 0;

            $http.get('/api/students/me/subjects').then(function(response){
                $scope.subjects = response.data;
                $scope.loading = false;
            });
            $scope.getChapters = function(subjectID) {
                $scope.loading = true;
                $scope.chapters = {};
                for(var i = 0; i<$scope.subjects.length; i++)
                {
                    if($scope.subjects[i].id == subjectID)
                    {
                        $scope.chapters = $scope.subjects[i].chapters;
                    }
                }
                if($scope.chapters && $scope.chapters[0] != null)
                {
                    $scope.hasChapters = true;
                    $scope.noChapters = false;
                }
                else {
                    $scope.hasChapters = false;
                    $scope.noChapters = true;
                }
                $scope.loading = false;
            }

            $scope.populateTopics = function(chapterID) {
                $scope.loading = true;
                $http.get('/api/desk/chapters/'+chapterID+'/material').then(function(response){
                    $scope.topics = response.data;
                    if($scope.topics && $scope.topics[0] !=undefined)
                    {
                        trust($scope.topics);
                        $scope.showTopics = true;

                    }
                    else
                    {
                        $scope.error = "No study material found for this chapter.";
                    }
                    $scope.loading = false;
                }, function(response) {
                    $scope.error = response.data.msg;
                    $scope.loading = false;
                });
            }
            function trust(topics)
            {
                for(var i = 0; i<topics.length; i++)
                {
                    topics[i].text = $sce.trustAsHtml(topics[i].text);
                }
            }
            $scope.changeTopic = function(index)
            {
                $scope.pointer = index;
            }
        });
})();
