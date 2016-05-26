(function(){

	var app = angular.module('Questions');

	app.factory('Question', function($http) {

        var Question = function (data) {

            angular.extend(this, data);
        }

        Question.get = function (id) {
            return $http.get('api/Questions/' + id).then(function (response) {
                return new Question(response.data);
            });
        };

				Question.getByChapterID = function(chapterID) {
						return $http.get('api/Chapters/'+chapterID+'/questions').then(function(response) {
								var Questions = [];
								for (var i = 0; i < response.data.length; i++) {
                    Questions.push(new Question(response.data[i]));
                }

                return Questions;
						})
				}

        Question.getAll = function () {
            return $http.get('api/Questions/all').then(function (response) {
                var Questions = [];
                for (var i = 0; i < response.data.length; i++) {
                    Questions.push(new Question(response.data[i]));
                }

                return Questions;
            });
        };

        Question.prototype.add = function () {
            var question = this;
            return $http.post('api/Questions/add', question).then(function (response) {
                return response.data.msg;
            });
        }

        Question.prototype.delete = function () {
            var question = this;

            return $http.get('api/Questions/' + question.id + '/delete').then(function (response) {
                return response.data.msg;
            });
        };

				Question.prototype.edit = function() {
						var question = this;
						console.log(question)
						return $http.post('api/Questions/' + question.id + '/edit', question).then(function(response) {
								console.log(response);
								return response.data.msg;
						})
				}
        return Question;
    });
})();
