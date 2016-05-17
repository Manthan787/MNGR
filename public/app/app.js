(function(){

	var app = angular.module('adminApp',['Questions','Students','Attendances','Services','Settings','Chapters','Auth','User','Tests','Materials','SMS','Account','ngRoute','ngSanitize','Utils']);

	app.constant('USER_ROLES', {
			admin 			: 1,
			teacher 		: 2,
			accountant 	: 3
	});

	app.config(function($routeProvider, USER_ROLES){
		$routeProvider
        .when('/', {
            templateUrl:'app/home.html',
            controller: 'HomeController',
						data: {
								authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher, USER_ROLES.accountant]
						}
        })
        .when('/Questions/all', {
						templateUrl:'app/partials/Questions/allQuestions.html',
						controller : 'QuestionsController',
						data: {
								authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher]
						}

				})
				.when('/Questions/add', {
					templateUrl:'app/partials/Questions/addQuestion.html',
					controller : 'AddQuestionsController',
		      data: {
							authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher]
					}
				})
				.when('/Questions/:id', {
					templateUrl:'app/partials/Questions/editQuestion.html',
					controller : 'EditQuestionController',
		      data: {
							authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher]
					}
				})
        .when('/Materials/add', {
            templateUrl:'app/partials/Materials/addMaterial.html',
            controller:'AddMaterialController',
						data: {
								authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher]
						}
        })
        .when('/Materials/recent', {
            templateUrl:'app/partials/Materials/recentMaterial.html',
            controller:'RecentMaterialController',
						data: {
								authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher]
						}
				})
				.when('/Materials/search', {
            templateUrl:'app/partials/Materials/searchMaterial.html',
            controller:'SearchMaterialController',
						data: {
								authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher]
						}
				})
        .when('/Materials/:id', {
            templateUrl:'app/partials/Materials/editMaterial.html',
            controller:'EditMaterialController',
						data: {
								authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher]
						}
        })
				.when('/Students/search', {
					templateUrl:'app/partials/Students/searchStudents.html',
					controller:'StudentsController',
					data: {
							authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher]
					}
				})
				.when('/Students/add', {
					templateUrl:'app/partials/Students/addStudent.html',
					controller:'AddStudentController',
					data: {
							authorizedRoles: [USER_ROLES.admin]
					}
		    })
				.when('/Attendance/mark', {
					templateUrl:'app/partials/Attendance/mark.html',
					controller:'MarkAttendanceController',
					data: {
							authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher]
					}
				})
				.when('/Attendance/view', {
					templateUrl:'app/partials/Attendance/view.html',
					controller:'ViewAttendanceController',
					data: {
							authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher]
					}
				})
    		.when('/Students/:id', {
          templateUrl:'app/partials/Students/showStudent.html',
          controller:'StudentShowController',
					data: {
							authorizedRoles: [USER_ROLES.admin]
					}
        })
				.when('/Alerts/send', {
					templateUrl:'app/partials/SMS/send.html',
					controller:'SMSController',
					data: {
							authorizedRoles: [USER_ROLES.admin]
					}
				})
				.when('/Settings/setup', {
					templateUrl:'app/partials/Settings/setup.html',
					controller:'SettingsController',
					data: {
							authorizedRoles: [USER_ROLES.admin]
					}
				})
        .when('/Settings/staff', {
            templateUrl:'app/partials/Settings/staff.html',
            controller:'StaffController',
						data: {
								authorizedRoles: [USER_ROLES.admin]
						}
        })
        .when('/Settings/financial-year', {
            templateUrl:'app/partials/Settings/year.html',
            controller:'YearController',
						data: {
								authorizedRoles: [USER_ROLES.admin]
						}
        })
        .when('/Settings/batches', {
            templateUrl : 'app/partials/Settings/batches.html',
            controller: 'AddBatchController',
						data: {
								authorizedRoles: [USER_ROLES.admin]
						}
        })
        .when('/Chapters', {
            templateUrl:'app/partials/Chapters/all.html',
            controller:'ChapterController',
						data: {
								authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher]
						}
        })
        .when('/Tests/create', {
            templateUrl : 'app/partials/Tests/create.html',
            controller : 'CreateTestController',
						data: {
								authorizedRoles: [USER_ROLES.admin]
						}
        })
				.when('/Tests/all', {
            templateUrl : 'app/partials/Tests/all.html',
            controller : 'AllTestsController',
						data: {
								authorizedRoles: [USER_ROLES.admin]
						}
        })
				.when('/Account/settings', {
						templateUrl: 'app/partials/Account/settings.html',
						controller: 'AccountSettings',
						data: {
								authorizedRoles: [USER_ROLES.admin, USER_ROLES.teacher, USER_ROLES.accountant]
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


		app.run(function($rootScope, AuthService, $window, $location) {
				$rootScope.$on('$routeChangeStart', function(event, next, current) {
						if(next.data) {
							var authorizedRoles = next.data.authorizedRoles;

							if(!AuthService.isAuthorized(authorizedRoles)) {
								event.preventDefault();
								if(AuthService.isAuthenticated()) {
										$location.path('/');
								}
								else {
										$window.location.href ='/admin/login'
								}
							}
						}
						if(tinymce != undefined && tinymce.activeEditor != undefined) {
							tinymce.activeEditor.remove()
						}
				});
		});

})();
