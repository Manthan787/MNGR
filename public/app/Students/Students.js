(function(){

	var app = angular.module('Students',[]);

	app.controller('StudentsController',function($scope, Student, $http){

		$scope.students = [];
		$scope.error;
		$scope.loading = true;

		var loadStudents = function(){
            Student.getAll()
            .then(function(allStudents){
                if(allStudents.length === 0)
                {
                    $scope.noStudents = true;
                }
                $scope.students = allStudents;
                $scope.loading =  false;


            }, function(response){
                console.log("ERROR!");
                $scope.success = null;
                $scope.loading = false;
                $scope.error = response.data.msg;
            });

        }

        loadStudents();

        $scope.delete = function(id)
        {
            var answer = confirm("Are You Sure You Want To Delete This Student?");
            if(answer == true)
            {
                var deletePromise = Student.delete(id);
                deletePromise.then(function(msg){
                    $scope.error = null;
                    $scope.success = msg;
                    loadStudents();
                });

            }
        }

	});
	app.controller('AddStudentController',function($scope,Student, SchoolFinder, FormHelper, $http, $filter){

		$scope.standards = [];
		$scope.hasStreams = false;
		$scope.loading = true;
		$scope.newStudent =  new Student;
        $scope.addUserForm;
        $scope.submitted = false;
        $http.get('api/years/current').then(function(response){
            $scope.currentYear = response.data;
        });
        $scope.newStudent.entry_date = new Date();
		//Get all the available standards from the API
		FormHelper.getStandards().then(function(standards){
				$scope.standards = standards;
		});

		FormHelper.getMediums().then(function(mediums){
				$scope.mediums = mediums;
        $scope.loading = false;
		});
        $scope.prepareStreams = function(std)
        {
            $scope.hasBatches = false;
            $scope.newStudent.stream = null;
            $scope.newStudent.fees = null;
            var streams = FormHelper.loadStreams(std);
            if(streams)
            {
                $scope.streams = streams;
                $scope.subjects = null;
                $scope.showSubjects = false;
                $scope.hasStreams = true;
            }
            else
            {
                $scope.hasStreams = false;
                $scope.prepareSubjectsByStd(std);
            }
            prepareBatches(std);
        }

        function prepareBatches(std)
        {
            if(std.batches && std.batches[0] != undefined)
            {
                $scope.batches = std.batches;
                $scope.hasBatches = true;
            }
            else
            {
                $scope.hasBatches = false;
            }
        }

        $scope.prepareSubjectsByStream = function(stream) {
            if(stream)
            {
                FormHelper.getSubjectsByStream(stream.id).then(function(subjects){
                    $scope.subjects = subjects;
                    $scope.showSubjects = true;
                });
            }
            else
            {
                $scope.subjects = [];
                $scope.showSubjects = false;
            }
        }

		$scope.prepareSubjectsByStd = function(std){
			if(std)
			{
        $scope.subjects = FormHelper.getSubjectsByStd(std.id, $scope.standards);
        $scope.showSubjects = true;
			}
			else
			{
				$scope.subjects = [];
				$scope.showSubjects = false;
			}
		}

		$scope.calculateFees = function(){

	      $scope.newStudent.fees = FormHelper.calculateFees($scope.newStudent.subjects);

		}

		$scope.search = function(){

			if($scope.newStudent.school)
			{

				SchoolFinder.search($scope.newStudent.school).then(function(response){

					$scope.schools = response.data;
				});
			}
			else
			{
				$scope.schools = null;
			}

		}

		$scope.approveSuggestion = function(school){
			//assign suggestion
			$scope.newStudent.school = school.name;
			//clear suggestions
			$scope.schools = null;
		}
        var convert = function(date) {
            return $filter('date')(date, 'yyyy-MM-dd');
        }
        var prepare = function() {
            $scope.newStudent.year_id = $scope.currentYear.id;
            $scope.newStudent.birthdate = convert($scope.newStudent.birthdate);
            $scope.newStudent.entry_date = convert($scope.newStudent.entry_date);
        }
		$scope.addStudent = function(isValid){
            $scope.submitted = true;
            if(isValid) {
								$scope.loading = true;
                document.body.scrollTop = document.documentElement.scrollTop = 0;
                $scope.loading = true;
                prepare();
                $scope.newStudent.add().then(function (msg) {
                    $scope.loading = false;
										$scope.error = '';
                    $scope.success = msg;
                    reset();
										$scope.loading = false;
                }, function (response) {
                    $scope.loading = false;
                    console.log(response);
										$scope.success = '';
                    $scope.error = response.data.msg;
										$scope.loading = false;
                });

                $scope.submitted = false;
                $scope.addUserForm.$setPristine();
            }

		}

		var reset = function(){
			$scope.newStudent = new Student;
            $scope.newStudent.entry_date = new Date();
            $scope.showSubjects = false;
            $scope.fees = 0;
		}


	});

	app.controller('SearchController',function($scope, $http){
		$scope.searchTerm;

		$scope.search = function(){
			if($scope.searchTerm == '')
			{
				$scope.schools = null;
			}
			$http.get('/api/schools/search/'+$scope.searchTerm).then(function(response){
				$scope.schools = response.data;
			});
		}

		$scope.approveSuggestion = function(school){
			//assign suggestion
			$scope.searchTerm = school.name;
			//clear suggestions
			$scope.schools = null;
		}

	});

    app.controller('StudentShowController', function($scope, $http, Student, FormHelper, $routeParams, $filter){
        $scope.loading = true;
        $scope.showSubjects = true;

        Student.show($routeParams.id).then(function(data) {
            $scope.Student = data;
            $scope.Student.birthdate = new Date($scope.Student.birthdate);
            $scope.Student.entry_date = new Date($scope.Student.entry_date);
            FormHelper.getStandards().then(function (standards) {

                $scope.standards = standards;
                var std = FormHelper.findCurrentStandard($scope.Student.standard_id, $scope.standards);
                $scope.streams = FormHelper.loadStreams(std);
                if ($scope.streams) {
                    $scope.hasStreams = true;
                    FormHelper.getSubjectsByStream($scope.Student.stream_id).then(function (subjects) {
                        $scope.subjects = subjects;
                    });
                }
                else {
                    $scope.subjects = FormHelper.getSubjectsByStd(std.id, standards);
                }
            });
            FormHelper.getMediums().then(function (mediums) {
                $scope.mediums = mediums;
            });
            $http.get('api/years/current').then(function(response){
                $scope.currentYear = response.data;
            });
            $http.get('api/Standards/'+$scope.Student.standard_id+"/batches").then(function(response){

                $scope.batches = response.data;
            });
            $scope.loading = false;
        });

        function prepareBatches(std)
        {
            if(std.batches && std.batches[0] != undefined)
            {
                $scope.batches = std.batches;
                $scope.hasBatches = true;
            }
            else
            {
                $scope.hasBatches = false;
            }
        }
        $scope.calculateFees = function(){

            $scope.Student.fees = FormHelper.calculateFees($scope.Student.subjects);
            console.log($scope.Student);
        }

        var convert = function(date) {
            return $filter('date')(date, 'yyyy-MM-dd');
        }
        var prepare = function() {
            $scope.Student.year_id = $scope.currentYear.id;
            $scope.Student.birthdate = convert($scope.Student.birthdate);
            $scope.Student.entry_date = convert($scope.Student.entry_date);
        }

        $scope.update = function(isValid)
        {
            $scope.submitted = true;
            if(isValid) {
                prepare();
                $scope.Student.update().then(function (msg) {
                    document.body.scrollTop = document.documentElement.scrollTop = 0;
                    $scope.error = null;
                    $scope.success = msg;
                    $scope.submitted = false;
                    $scope.editUserForm.$setPristine();
                }, function (response) {
                    console.log(response);
                    $scope.success = null;
                    document.body.scrollTop = document.documentElement.scrollTop = 0;
                    $scope.error = "There was an error while updating this record.";
                    $scope.submitted = false;
                });
            }
        }
        $scope.refresh = function()
        {
            location.reload();
        }

        $scope.prepareStreams = function(std)
        {
            $scope.Student.stream = null;
            $scope.Student.fees = null;
            $scope.Student.subjects = null;
            var streams = FormHelper.loadStreams(std);
            if(streams)
            {
                $scope.streams = streams;
                $scope.subjects = null;
                $scope.hasStreams = true;
            }
            else
            {
                $scope.streams = [];
                $scope.hasStreams = false;
                $scope.prepareSubjectsByStd(std);
            }
            prepareBatches(std);
        }

        $scope.prepareSubjectsByStd = function(std){
            if(std)
            {
                $scope.subjects = FormHelper.getSubjectsByStd(std.id, $scope.standards);
                $scope.showSubjects = true;
            }
            else
            {
                $scope.subjects = [];
                $scope.showSubjects = false;
            }
        }

        $scope.prepareSubjectsByStream = function(stream) {
            if(stream)
            {
                FormHelper.getSubjectsByStream(stream.id).then(function(subjects){
                    $scope.subjects = subjects;
                    $scope.showSubjects = true;
                });
            }
            else
            {
                $scope.subjects = [];
                $scope.showSubjects = false;
            }
        }
    });

})();
