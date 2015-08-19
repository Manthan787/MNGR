(function(){

	var app = angular.module('adminApp',['Questions','Students','Services','Settings','Chapters','Auth','User','Tests','Materials','ngRoute','ngSanitize']);

	app.config(function($routeProvider){
		$routeProvider
        .when('/', {
            templateUrl:'app/home.html',
            controller: 'HomeController',
            resolve: {
                        load :  function($q, $window)
                        {
                            var deferred = $q.defer();
                            if (!sessionStorage.authenticated) {
                                $window.location.href = '/admin/login';
                                deferred.reject();
                            }
                            else {
                                deferred.resolve();
                            }
                            return deferred.promise;
                        }
                    }

        })
        .when('/Questions/all', {
			templateUrl:'app/partials/Questions/allQuestions.html',
			controller : 'QuestionsController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }
		})
		.when('/Questions/add', {
			templateUrl:'app/partials/Questions/addQuestion.html',
			controller : 'AddQuestionsController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }
		})
        .when('/Materials/add', {
            templateUrl:'app/partials/Materials/addMaterial.html',
            controller:'MaterialsController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }
        })
            .when('/Materials/recent', {
                templateUrl:'app/partials/Materials/recentMaterial.html',
                controller:'RecentMaterialController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }
            })
            .when('/Materials/:id', {
                templateUrl:'app/partials/Materials/editMaterial.html',
                controller:'MaterialsController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }
            })
		.when('/Students/search', {
			templateUrl:'app/partials/Students/searchStudents.html',
			controller:'StudentsController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }

		})
		.when('/Students/add', {
			templateUrl:'app/partials/Students/addStudent.html',
			controller:'AddStudentController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }
            })

        .when('/Students/:id', {
                templateUrl:'app/partials/Students/showStudent.html',
                controller:'StudentShowController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }
            })
		.when('/Settings/setup', {
			templateUrl:'app/partials/Settings/setup.html',
			controller:'SettingsController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }
		})
        .when('/Settings/staff', {
            templateUrl:'app/partials/Settings/staff.html',
            controller:'StaffController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }
        })
        .when('/Settings/financial-year', {
            templateUrl:'app/partials/Settings/year.html',
            controller:'YearController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }
        })
        .when('/Settings/batches', {
            templateUrl : 'app/partials/Settings/batches.html',
            controller: 'BatchController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }

        })
        .when('/Chapters', {
                templateUrl:'app/partials/Chapters/all.html',
                controller:'ChapterController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }
        })
        .when('/Tests/create', {
                templateUrl : 'app/partials/Tests/create.html',
                controller : 'TestController',
                resolve: {
                    load :  function($q, $window)
                    {
                        var deferred = $q.defer();
                        if (!sessionStorage.authenticated) {
                            $window.location.href = '/admin/login';
                            deferred.reject();
                        }
                        else {
                            deferred.resolve();
                        }
                        return deferred.promise;
                    }
                }

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

    //Resolve is much better than this option!
    /*app.run(function($rootScope, $window){
        $rootScope.$on('$routeChangeStart', function(event){
            if(!sessionStorage.authenticated) {
                event.preventDefault();
                $window.location.href = "/login";
            }
        });
    }); */

})();