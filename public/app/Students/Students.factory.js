(function(){

	var app = angular.module('Students');

	app.factory('Student',function($http){

		var Student = function(data){
			angular.extend(this, data);
		}

		Student.getAll = function() {
			return $http.get('api/Students/all').then(function(response){
				var Students = [];
				for(var i = 0; i<response.data.length;i++)
				{
					Students.push(new Student(response.data[i]));
				}
				return Students;
			});
		};

		Student.getByBatch = function(batchID) {
				return $http.get('api/batches/'+batchID+'/students')
							 .then(function(response) {								 	
								 	return response.data;
							 })
		}

		Student.prototype.add = function(){
			var student = this;
			return $http.post('/api/Students/add', student).then(function(response){
				return response.data.msg;
			});
		};

    Student.delete = function(id){

        return $http.get('/api/Students/'+id+'/delete').then(function(response){
            return response.data.msg;
        });
    };

    Student.show = function(id){
        return $http.get('/api/Students/'+id).then(function(response){
           return new Student(response.data);
        });
    }

    Student.prototype.update = function(){
        return $http.post('/api/Students/'+this.id+'/update', this).then(function(response){
            return response.data.msg;
        });
    }
		return Student;

	});


})();
