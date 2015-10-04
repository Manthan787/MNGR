(function(){

	var app = angular.module('Questions',[]);

	app.controller('QuestionsController',function($scope, Question, $location, $sce){
		$scope.questions = [];
		$scope.error;
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
            $scope.loading = true;
            question.delete().then(function(msg){
                $scope.success = msg;
                loadQuestions();
                $scope.loading = false;
            });
        }
	});

    app.controller("AddQuestionsController", function($scope){
        $scope.editEnabled = false;

    });
	app.controller('AddQuestionFormController',function($scope, Question, Standard, FormHelper, $http, $sce){
        init_editor()
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

			function init_editor() {
				tinymce.init({
					selector: '#question',
					menubar: false,
					plugins: [
			        "advlist autolink lists link image charmap print preview anchor",
			        "searchreplace visualblocks code fullscreen",
			        "insertdatetime media table contextmenu paste youTube"
			    ],
    			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image youTube",
					file_browser_callback: function(field_name, url, type, win) {
            if(type=='image') $('#my_form input').click();
        	},
					setup: function(editor) {
										editor.on('keyup', function(e) {
												var elm = document.getElementById('AddForm')
												var scope = angular.element(elm).scope()
												scope.$apply(function() {
														$scope.newQuestion.question = editor.getContent()
												})
										})
								}
				})
			}
	});



})();
