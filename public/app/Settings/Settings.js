(function(){

	var app = angular.module('Settings',[]);

	app.controller('SettingsController',function($scope, $http, Standard){
        $scope.populator = false;
		$scope.noStreams = false;
		$scope.noStandards = false;
		$scope.noSubjects = false;
		$scope.currentStd = new Standard;
		$scope.standards = [];
		$scope.success;
		$scope.error;
	    $scope.loading = true;

		$scope.loadStandards = function(){
			var stdPromise = Standard.getAll();
			stdPromise.then(function(stds){
				if(stds.length == 0)
					$scope.noStandards = true;
				else
					$scope.noStandards = false;
					$scope.standards = stds;

			});

            $scope.loading = false;
		}

		$scope.loadStandards();

		$scope.populateData = function(standard){
			//console.log(standard);
	
				$scope.currentStd = standard;
				$scope.populator = true;
				
				checkAndAssignStreams(standard);
				checkAndAssignSubjects(standard);	
			
		}

		$scope.fetchStandard = function(standard){

			standard.get().then(function(std){
				$scope.currentStd = std;
				$scope.populator = true;

				checkAndAssignStreams(std);
				checkAndAssignSubjects(std);
			});

		}

		var checkAndAssignStreams = function(standard)
		{
			if($scope.currentStd.streams.length == 0)
			{
				$scope.noStreams = true;
			}
			else
			{
				$scope.noStreams = false;
				$scope.currentStd.streams = standard.streams;
			}
		}


		var checkAndAssignSubjects = function(standard)
		{
			if($scope.currentStd.subjects.length == 0)
			{
				$scope.noSubjects = true;
			}
			else
			{
				$scope.noSubjects = false;
				$scope.currentStd.subjects = standard.subjects;
			}
		}

		$scope.removeStandard = function(standard){
			
			var ans = confirm("Deleting the standard will result in deletion of all the streams, subjects and students associated with it. Are you sure you want to do this?")
			if(ans == true)
			{
				var delPromise = standard.remove();
				delPromise.then(function(msg){
					$scope.currentStd = new Standard;
					$scope.success = msg;
					$scope.populator = false;
					$scope.loadStandards();
					document.body.scrollTop = document.documentElement.scrollTop = 0;

				});
			}

		}


		$scope.enableEditStd = function(stdID){

			$scope.editableID = stdID;
		}

		$scope.disableEdit = function(){
			$scope.editableID = null;
		}

		$scope.isEditable = function(stdID){
			if($scope.editableID == stdID)
				return true;
			else
				return false;
		}

		$scope.edit = function(standard){
			standard.edit().then(function(data){
				$scope.success = data.msg;
				$scope.disableEdit();

			});
		}

		

		
	});

	app.controller('StdFormController',function($scope, Standard){
		
		$scope.reset = function(){

			$scope.newStandard = new Standard;
			$scope.newStandard.streams = [];
			$scope.newStandard.subjects = [];
		}

		$scope.reset();

		var counter = 0;
		$scope.newStream = function(){
			counter++;
			$scope.newStandard.streams.push({id:counter, stream:""})
		}

		$scope.removeStream = function(stream){
			var index = $scope.newStandard.streams.indexOf(stream);
			$scope.newStandard.streams.splice(index,1);
			counter--;

		}


		$scope.addStandard = function(){
			var addPromise;
			addPromise = $scope.newStandard.add();

			addPromise.then(function(data){

				console.log(data);
				$scope.$parent.success = data.msg;
				$scope.reset();
				$scope.loadStandards();
				document.body.scrollTop = document.documentElement.scrollTop = 0;

			}, function(response){

				$scope.$parent.error = response.data.msg;
				document.body.scrollTop = document.documentElement.scrollTop = 0;

			});
			
		}


	});

	app.controller('StreamFormController', function($scope, $http){
		$scope.streams = [];
		var counter = 0;

		$scope.addNewStream = function(){
			$scope.streams.push({id:counter, stream:""});
			counter++;
		}

		$scope.deleteStream = function(stream){
			var index = $scope.streams.indexOf(stream);
			$scope.streams.splice(index,1);
			counter--;

		}
	
		$scope.save = function(){
			$http.post('/api/Standards/'+$scope.currentStd.id+'/Streams/add', $scope.streams)
			.then(function(response){
			
				$scope.$parent.success = response.data.msg;
				$scope.streams = [];
				$scope.loadStandards();
				$scope.fetchStandard($scope.currentStd);
				counter = 0;

			}, function(response){
				$scope.$parent.error = response.data.msg;
			});
		}

		

		$scope.submittable = function(){
			if(counter>0)
				return true;
			else
				return false;
		}

	});

	app.controller('StreamsTableController', function($scope, $http){

		$scope.removeStream = function(stream){
			var ans = confirm("Deleting Streams will result in deletion of all the subjects and students associated with this stream. Are you sure you want to do this?");
			if(ans == true)
			{	
				$http.post('/api/Streams/delete', stream).then(function(response){
					$scope.$parent.success = response.data.msg;
					$scope.loadStandards();
					$scope.fetchStandard($scope.currentStd);
				});
			}
		}

		$scope.enableEditStream = function(streamID){

			$scope.editableStreamID = streamID;
		}

		$scope.disableEditStream = function(){
			$scope.editableStreamID = null;
		}

		$scope.streamIsEditable = function(streamID){
			if($scope.editableStreamID == streamID)
				return true;
			else
				return false;
		}

		$scope.editStream = function(stream){
			$http.post('/api/Streams/'+stream.id+'/edit', stream).then(function(response){
				$scope.$parent.success = response.data.msg;
				$scope.disableEditStream();

			});
		}

	});

	app.controller('SubjectFormController', function($scope, $http){


		$scope.saveWithStream = function(){

			$http.post('/api/Standards/'+$scope.$parent.currentStd.id+'/Streams/'+$scope.newSubject.stream+'/Subjects/add', $scope.newSubject)
			.then(function(response){
				$scope.newSubject = null;
				$scope.loadStandards();
				$scope.fetchStandard($scope.currentStd);
				$scope.$parent.success = response.data.msg;

			}, function(response){
				$scope.$parent.error = response;
			});
		}

		$scope.save = function(){
			$http.post('/api/Standards/'+$scope.$parent.currentStd.id+'/Subjects/add', $scope.newSubject)
			.then(function(response){
				$scope.newSubject= null;
				$scope.loadStandards();
				$scope.fetchStandard($scope.currentStd);
				$scope.$parent.success = response.data.msg;

			});
		}

		
	});

	app.controller('SubjectsTableController', function($scope, $http){

		$scope.delete = function(subject){
			var ans = confirm("Deleting this subject will result in deletion of all the questions related to this subject. Are you sure you want to delete this subject?");
			if(ans == true)
			{
				$http.post('/api/Subjects/delete', subject)
				.then(function(response){
					
						$scope.loadStandards();
						$scope.fetchStandard($scope.currentStd);
						$scope.$parent.success = response.data.msg;
					

				}, function(response){
					$scope.$parent.error = response.data.msg;
				});
			}
		}
		$scope.enableEditSub = function(subID){

			$scope.editableSubID = subID;
		}

		$scope.disableEditSub = function(){
			$scope.editableSubID = null;
		}

		$scope.subjectIsEditable = function(subID){
			if($scope.editableSubID == subID)
				return true;
			else
				return false;
		}

		$scope.editSubject = function(subject){
			$http.post('/api/Subjects/'+subject.id+'/edit', subject)
			.then(function(response){

				$scope.$parent.success = response.data.msg;
				$scope.disableEditSub();
			}, function(response){
				$scope.$parent.error = response.data;
				document.body.scrollTop = document.documentElement.scrollTop = 0;
			});

		}

	});

})();