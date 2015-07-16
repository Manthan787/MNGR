(function(){
    angular.module('desk',['ngSanitize'])
        .controller('NavController', function($scope){
            $scope.active = 1;
            $scope.isActive = function(value) {
                return (value == $scope.active) ? true : false;
            }

        })
        .controller('TestController', function($scope, $http, $sce){
            $scope.loading = true;
            $scope.questions = {};
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

            $scope.generate = function(isValid) {
                $scope.submitted = true;
                if(isValid) {
                    $scope.loading = true;
                    $http.post('/api/desk/test/practice/generate',$scope.test).then(function(response) {
                        $scope.questions = response.data;
                        $scope.loading = false;
                        $scope.generated = true;
                        $scope.practiceTest.$setPristine();
                    }, function(response){
                        console.log(response);
                        $scope.error = response.data.msg;
                        $scope.loading = false;
                    });
                }

            }
        })
        .controller('TestpaperController', function($scope,$http, $sce) {
            $scope.enableInstructions = true;
            $scope.hasBegun = false;
            $scope.pointer = -1;

            $scope.next = function()
            {
                $scope.pointer = $scope.pointer + 1;
                if($scope.pointer == $scope.questions.length)
                {
                    $scope.hasEnded = true;
                    $scope.hasBegun = false;
                }

            }
            $scope.previous = function()
            {
                $scope.pointer = $scope.pointer - 1;

                if($scope.pointer <= $scope.questions.length-1)
                {
                    $scope.hasEnded = false;
                    $scope.hasBegun = true;
                }


            }

            $scope.begin = function()
            {
                $scope.enableInstructions = false;
                $scope.hasBegun = true;
                ++ $scope.pointer;
            }

            $scope.assess = function()
            {
                $scope.$parent.loading = true;
                prepare($scope.questions);
                $http.post('/desk/test/practice/assess', $scope.questions).then(function(response){
                    console.log(response.data);
                    $scope.report = response.data;
                    $scope.hasReport = true;
                    $scope.hasEnded = false;
                    $scope.$parent.loading = false;
                }, function(response){
                    console.log(response);
                });
            }
            function prepare(questions)
            {
                for(var i = 0; i<$scope.questions.length; i++)
                {
                        if(!questions[i].attempted_answer)
                        {
                            questions[i].attempted_answer = 0;
                        }
                }
            }
            window.addEventListener("beforeunload", function(e){
                if($scope.hasBegun) {
                    (e || window.event).returnValue = "If you leave this page, your test progress will not be saved. You will have to generate a new test.";
                }
            });

            window.addEventListener("keydown", handleKeyEvent);
            function handleKeyEvent(event)
            {
                if($scope.generated)
                {
                    e = document.getElementById('test');
                    scope = angular.element(e).scope();
                    if(event.keyCode == 39 && $scope.pointer != $scope.questions.length)
                    {
                        event.preventDefault();
                        scope.$apply(function(){
                            $scope.next();
                        });

                    }
                    if(event.keyCode == 37 && $scope.pointer != 0)
                    {
                        event.preventDefault();
                        scope.$apply(function(){
                            $scope.previous();
                        });
                    }
                }
            }
        })
        .controller('ReportController', function($scope){
            $scope.hasIncorrectAnswers = function() {
                if($scope.report.incorrect[0] != undefined)
                {
                    return true;
                }
                return false;
            }
            $scope.hasCorrectAnswers = function() {
                if($scope.report.correct[0] != undefined)
                {
                    return true;
                }
                return false;
            }
            $scope.hasUnattemptedAnswers = function() {
                if($scope.report.unattempted[0] != undefined)
                {
                    return true;
                }
                return false;
            }

            $scope.student_answer = function(options, id) {
                for(var i = 0; i < options.length; i++)
                {
                    if(options[i].id == id)
                    {
                        return options[i].option;
                    }
                }
            }

            $scope.correct_answer = function(options, id) {
                for(var i = 0; i < options.length; i++)
                {
                    if(options[i].id == id)
                    {
                        return options[i].option;
                    }
                }
            }
        })
        .config(function ($sceDelegateProvider) {
            $sceDelegateProvider.resourceUrlWhitelist([
                'self',   // trust all resources from the same origin
                '*://www.youtube.com/**'   // trust all resources from `www.youtube.com`
            ]);
        });

})();