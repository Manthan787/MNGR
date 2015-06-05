(function(){

	var app = angular.module('Questions');

	app.factory('Question', function($http){

		var Question = function(data){
			
			angular.extend(this, data);	
		}

		Question.get = function(id){
			return $http.get('api/Questions/'+id).then(function(response){
				return new Question(response.data);
			});
		}; 

		Question.getAll = function(){
			return $http.get('api/Questions/all').then(function(response){
				var Questions = [];
				for(var i = 0; i<response.data.length; i++)
				{
					Questions.push(new Question(response.data[i]));
				}

				return Questions;
			});
		};

		Question.prototype.add = function(){
			var question = this;
			return $http.post('api/Questions/add', question).then(function(response) {
				return response.data.msg;
			});
		}

		return Question;
	});


})();