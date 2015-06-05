(function(){

	var app = angular.module('Questions',[]);

	app.controller('QuestionsController',function($scope, Question, $location){
		
		$scope.questions = [];
		$scope.error;
		$scope.fetchedQuestion;

		$scope.fetchQuestion = function(id){
			var fetchQuestionPromise = Question.get(id);
			fetchQuestionPromise.then(function(q){
				
				$scope.fetchedQuestion = q;
				//console.log($scope.fetchedQuestion);

			});
		};
		var promise = Question.getAll();
		promise.then(function(q){
			if(q.length === 0)
			{
				$scope.error = "There is nothing to display! Try adding some questions and check back later!";
			}
			else
			{
				$scope.questions = q;	
			}

		}, function(response){

			$scope.error = response.data.msg;
		});

	});

    app.controller("AddQuestionsController", function($scope){
        $scope.editEnabled = false;

    });
	app.controller('AddQuestionFormController',function($scope, Question, Standard, FormHelper, $http){
        $scope.newQuestion = new Question();
        var counter = 4;
        $scope.newQuestion.options = [{id: 1, option: "", answer:0},{id: 2, option: "", answer:0},{id: 3, option: "", answer:0},{id: 4, option: "", answer:0}];
        $scope.streams = [];
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
        $scope.getChapters = function(subject) {
            $http.get("api/Subjects/"+subject.id+"/Chapters").then(function(response){
                $scope.chapters = response.data;
                if($scope.chapters[0] != undefined) {
                    $scope.hasChapters = true;
                }
            });
        };


		$scope.newOption = function(){
			counter++;
			$scope.newQuestion.options.push({id: counter, option: "", answer:0});

		}

		$scope.removeOption = function(option){
			var index = $scope.newQuestion.options.indexOf(option);
			$scope.newQuestion.options.splice(index,1);
			counter--;
		}

		$scope.addQuestion = function(){
            $scope.loading = true;
			var addQuestionPromise = $scope.newQuestion.add();
			addQuestionPromise.then(function(msg){
                console.log(msg);
                $scope.$parent.success = msg;
				reset();
                $scope.loading = false;
			}, function(response){
				console.log(response);
			});
		}

		var reset = function(){
			counter =  4;
            var prevChapter = $scope.newQuestion.chapter_id;
			$scope.newQuestion = new Question();
            $scope.newQuestion.chapter_id = prevChapter;
            $scope.newQuestion.options = [{id: 1, option: "", answer:0},{id: 2, option: "", answer:0},{id: 3, option: "", answer:0},{id: 4, option: "", answer:0}];
		
		}

        $scope.selectAnswer = function(option) {
            option.answer = 1;
        }
	});

})();