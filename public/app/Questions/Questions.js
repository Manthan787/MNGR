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

    app.controller("AddQuestionsController", function($scope, Question, Standard, FormHelper){
        $scope.editEnabled = false;
        $scope.streams = [];
        var resetStates = function() {
            $scope.hasStreams = false;
            $scope.hasSubjects = false;
            $scope.subjectsError = false;
        }
        Standard.getAll().then(function(standards){
            $scope.standards = standards;
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

          FormHelper.getSubjectsByStream(stream.id).then(function(subjects){
              $scope.subjects = subjects;

              if($scope.subjects[0] != undefined) {
                  $scope.hasSubjects = true;
                  $scope.subjectsError = false;
              }
              else {
                  $scope.hasSubjects = false;
                  $scope.subjectsError = true;
              }
          });

        };

    });
	app.controller('AddQuestionFormController',function($scope, Question, Standard){
		$scope.newQuestion = new Question();
		var counter = 4;
		$scope.newQuestion.options = [{id: 1, option: "", answer:0},{id: 2, option: "", answer:0},{id: 3, option: "", answer:0},{id: 4, option: "", answer:0}];
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
			console.log($scope.newQuestion);
			var addQuestionPromise = $scope.newQuestion.add();
			addQuestionPromise.then(function(q){
				console.log(q);
				reset();
			}, function(response){
				console.log(response);
			});
		}

		var reset = function(){
			var counter =  1;
			$scope.newQuestion = new Question();
			$scope.newQuestion.options = [{id: counter, option: "Option "+counter}];
		
		}
	});

})();