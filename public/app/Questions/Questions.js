(function(){

	var app = angular.module('Questions',['Utils']);
	app.directive("questionCard", function() {
			return {
				restrict : 'E',
				templateUrl: 'app/partials/Questions/Directives/question-card.html'
			}
	})

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
				$http.get("api/Subjects/"+subject+"/Chapters").then(function(response){
						$scope.chapters = response.data;
						if($scope.chapters[0] != undefined) {
								$scope.hasChapters = true;
						}
						$scope.loading = false;
				});
		};

  });

	app.controller("SearchQuestionController", function($scope, $http, Question) {
			$scope.$parent.loadStds();
			var currentChapterID;
			$scope.fetchQuestions = function(selectedChapter) {
				currentChapterID = selectedChapter
				Question.getByChapterID(selectedChapter).then(function(response) {
						$scope.questions = response
				})
			}

			$scope.delete = function(question) {
				var ans = confirm("Are you sure you want to delete this question?");
				if (ans == true) {
					question.delete().then(function(response) {
							$scope.success = response
							$scope.fetchQuestions(currentChapterID)
					})
				}
			}
	})

	app.controller("EditQuestionController", function($scope, Question, $routeParams, Editor, $http) {
			$scope.loading = true

			Question.get($routeParams.id).then(function(question) {
					$scope.question = question;
					Editor.init(setup)
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
			 $scope.question.answer.option_id = parseInt(option.id)
		 }
		 $scope.editQuestion = function() {
			 	$scope.question.edit()
		 }

		 function setup(editor) {
				 editor.on('keyup', function(e) {
						 var elm = document.getElementById('EditForm')
						 var scope = angular.element(elm).scope()
						 scope.$apply(function() {
								 $scope.question.question = editor.getContent()
						 })
				 })

				 editor.on('LoadContent', function() {
						 tinymce.activeEditor.setContent($scope.question.question)
				 })
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
