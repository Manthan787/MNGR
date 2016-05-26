(function(){

	var app = angular.module('Questions',['Utils']);

	app.controller('QuestionsController',function($scope, Question, $location, $sce){
		$scope.questions = [];
		$scope.fetchedQuestion;
    $scope.loading = true;
    loadQuestions();
		$scope.fetchQuestion = function(id){
			var fetchQuestionPromise = Question.get(id);
			fetchQuestionPromise.then(function(q){
				$scope.fetchedQuestion = q;
			});
		};
		 function loadQuestions() {
            var promise = Question.getAll();
            promise.then(function (q) {
                if (q.length === 0) {
                    $scope.error = "There is nothing to display! Try adding some questions and check back later!";
                }
                else {
                    $scope.questions = q;
                    trust($scope.questions);
                }
                $scope.loading = false;
            }, function (response) {

                $scope.error = response.data.msg;
                $scope.loading = false;
            });
        };

        function trust(questions)
        {
            for(var i = 0; i<questions.length; i++)
            {
                questions[i].question = $sce.trustAsHtml(questions[i].question);
            }
        }
        $scope.delete = function(question) {
						$scope.success = 'Here it is!';
						$scope.error = 'cannot delete!';
            // $scope.loading = true;
            // question.delete().then(function(msg){
            //     $scope.success = msg;
            //     loadQuestions();
            //     $scope.loading = false;
            // });
        }
	});

  app.controller("QuestionsController", function($scope, $http, Standard, FormHelper){
		$scope.chapters = null

		var resetStates = function() {
				$scope.hasStreams = false;
				$scope.hasSubjects = false;
				$scope.subjectsError = false;
				$scope.hasChapters = false;
		}


		$scope.loadStds = function() {
			Standard.getAll().then(function(standards){
					$scope.standards = standards;
					$scope.loading = false;
			});
		}

		$scope.getStreams = function(selectedStandard) {
				$scope.loading = true;
				resetStates();
				console.log(selectedStandard)
				$scope.streams = FormHelper.loadStreams(selectedStandard);
				if($scope.streams)
				{
						$scope.hasStreams = true;
				}
				else
				{
						$scope.hasStreams = false;
						$scope.subjects = FormHelper.getSubjectsByStd(selectedStandard.id, $scope.standards);
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
				console.log(subject)
				$http.get("api/Subjects/"+subject+"/Chapters").then(function(response){
						$scope.chapters = response.data;
						if($scope.chapters[0] != undefined) {
								$scope.hasChapters = true;
						}
						$scope.loading = false;
				});
		};

  });

	app.controller("SearchController", function($scope, $http) {
			$scope.fetchQuestions = function(selectedChapter) {
				
			}
	})

	app.controller("EditQuestionController", function($scope, Question, $routeParams, Editor, $http) {
			$scope.loading = true
			Question.get($routeParams.id).then(function(question) {
					$scope.question = question;
					Editor.init(setup)
					function setup(editor) {
							editor.on('keyup', function(e) {
									var elm = document.getElementById('EditForm')
									var scope = angular.element(elm).scope()
									scope.$apply(function() {
											$scope.question.question = editor.getContent()
									})
							})
					}
			})

		 $http.get('api/Chapters/all').then(function(response) {
			 angular.forEach(response.data, function(chapter) {
				 	if(chapter.id == $scope.question.chapter_id) {
							selectedSubjectID = chapter.subject_id
					}
			 })

			 $http.get('api/Subjects/all').then(function(response) {
				 	$scope.subjects = response.data
					angular.forEach($scope.subjects, function(subject) {
						if(subject.id == selectedSubjectID) {
								$scope.$parent.chapters = subject.chapters
								$scope.selectedSubject = subject
						}
					})
					$scope.loading = false
			 })
		 })

		 $scope.selectAnswer =  function(option) {
			 console.log(option)
			 $scope.question.answer.option_id = parseInt(option.id)
		 }
		 $scope.editQuestion = function() {
			 	$scope.question.edit()
		 }


	})

	app.controller('AddQuestionFormController',function($scope, Question, Standard, FormHelper, $http, $sce, Editor){
			$scope.$parent.loadStds();
      $scope.newQuestion = new Question();
			var setup = function(editor) {
								editor.on('keyup', function(e) {
										var elm = document.getElementById('AddForm')
										var scope = angular.element(elm).scope()
										scope.$apply(function() {
												$scope.newQuestion.question = editor.getContent()
										})
								})
						}
			Editor.init(setup)

      var counter = 4;
      $scope.newQuestion.options = [{id: 1, option: "", answer:0},{id: 2, option: "", answer:0},{id: 3, option: "", answer:0},{id: 4, option: "", answer:0}];
      $scope.loading = true;


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
			    		tinymce.get('question').setContent('');
			};

      $scope.selectAnswer = function(option) {
          option.answer = 1;
          for(var i = 0; i<$scope.newQuestion.options.length; i++)
          {
              var currentOption = $scope.newQuestion.options[i];
              if(currentOption.answer == 1 && currentOption.id != option.id)
              {
                  currentOption.answer = 0;
              }
          }

      }

      $scope.promptNoChapterError = function() {
          $scope.$parent.error = "Please select a chapter first to enable adding question.";
      }

	});



})();
