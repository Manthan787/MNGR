(function(){

	var app = angular.module('adminApp',['Questions','Students','Services','Settings','Chapters','Auth','User','ngRoute']);
	
	app.config(function($routeProvider){
		$routeProvider
        .when('/dashboard', {
            templateUrl:'app/home.html',
            controller: 'HomeController'
        })
        .when('/', {
            templateUrl:'app/partials/Auth/login.html',
            controller:'LoginController'
        })
        .when('/Questions/all', {
			templateUrl:'app/partials/Questions/allQuestions.html',
			controller : 'QuestionsController'
		})
		.when('/Questions/add', {
			templateUrl:'app/partials/Questions/addQuestion.html',
			controller : 'AddQuestionsController'
		})
		.when('/Students/search', {
			templateUrl:'app/partials/Students/searchStudents.html',
			controller:'StudentsController'

		})
		.when('/Students/add', {
			templateUrl:'app/partials/Students/addStudent.html',
			controller:'AddStudentController'
            })

        .when('/Students/:id', {
                templateUrl:'app/partials/Students/showStudent.html',
                controller:'StudentShowController'
            })
		.when('/Settings/setup', {
			templateUrl:'app/partials/Settings/setup.html',
			controller:'SettingsController'
		})
        .when('/Settings/staff', {
            templateUrl:'app/partials/Settings/staff.html',
            controller:'StaffController'
        })
        .when('/Chapters', {
                templateUrl:'app/partials/Chapters/all.html',
                controller:'ChapterController'
        })
		.otherwise({
			redirectTo:'/'
		});
	}).factory('authHttpResponseInterceptor',['$q','$location',function($q,$location){
        return {
            response: function(response){
                if (response.status === 401) {
                    delete sessionStorage.authenticated;
                    delete sessionStorage.user;
                    $location.path('/');
                }
                return response || $q.when(response);
            },
            responseError: function(rejection) {
                if (rejection.status === 401) {
                    delete sessionStorage.authenticated;
                    delete sessionStorage.user;
                    $location.path('/');
                }
                return $q.reject(rejection);
            }
        }
    }])
        .config(['$httpProvider',function($httpProvider) {
            //Http Intercpetor to check auth failures for xhr requests
            $httpProvider.interceptors.push('authHttpResponseInterceptor');
        }]);
	



})();