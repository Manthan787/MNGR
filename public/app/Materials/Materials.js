(function(){
    angular.module('Materials', [])
        .filter('limitHtml', function() {
            return function(text, limit) {

                var changedString = String(text).replace(/<[^>]+>/gm, '');
                var length = changedString.length;

                return changedString.length > limit ? changedString.substr(0, limit - 1) : changedString;
            }
        })
        .controller("MaterialsController", function(){

        })
        .controller('AddMaterialController', function($scope, Standard, FormHelper, $http){
            $scope.newMaterial = {};
            init_editor()
            $scope.loading = true;
            var resetStates = function() {
                $scope.hasStreams = false;
                $scope.hasSubjects = false;
                $scope.subjectsError = false;
                $scope.hasChapters = false;
                tinymce.get('material_text').setContent('')
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

            $scope.addMaterial = function() {
                $http.post('api/materials/add', $scope.newMaterial).then(function(response){
                    $scope.$parent.success = response.data.msg;
                    resetStates();
                    $scope.newMaterial = {};
                }, function(response){
                    console.log(response);
                });
            }
            function init_editor() {
      				tinymce.init({
      					selector: '#material_text',
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
      														$scope.newMaterial.text = editor.getContent()
      												})
      										})
      								}
      				})
      			}
        })

        .controller('RecentMaterialController', function($scope, $http, $sce) {
            getRecent();
            function getRecent() {
                $scope.loading = true;
                $http.get('api/materials/recent').then(function(response){
                    $scope.materials = response.data;
                    trust($scope.materials);
                    $scope.loading = false;
                });
            }

            function trust(materials)
            {
                for(var i = 0; i<materials.length; i++)
                {
                    materials[i].text = $sce.trustAsHtml(materials[i].text);
                }
            }

            $scope.delete = function(id) {
                var ans = confirm('Are you sure you want to delete this item?');
                if(ans === true)
                {
                    $scope.loading = true;
                    $http.delete('api/materials/'+id+'/delete')
                        .then(function(response){
                            $scope.success = response.data.msg;
                            getRecent();
                            document.body.scrollTop = document.documentElement.scrollTop = 0;
                        },function(response){
                            $scope.error = response.data;
                            document.body.scrollTop = document.documentElement.scrollTop = 0;
                    });
                }
            }

        })
        .controller('EditMaterialController', function($scope, $http, $routeParams){
            $scope.$parent.loading = true;
            $http.get('api/materials/'+$routeParams.id).then(function(response){
                $scope.material = response.data;
                $scope.selectedSubject = response.data.subject.id;
                $scope.getChapters($scope.selectedSubject);
                init_editor()
                $scope.$parent.loading = false;

            });
            $scope.$parent.loading = true;
            $http.get('api/Subjects/all').then(function(response){
                $scope.subjects = response.data;
                $scope.$parent.loading = false;
            });

            $scope.isSelected = function(check, reference){
                if(check === reference)
                {
                    return true;
                }
                return false;
            }

            $scope.getChapters = function(subjectID) {
                $scope.loading = true;
                $http.get("api/Subjects/"+subjectID+"/Chapters").then(function(response){
                    $scope.chapters = response.data;
                    $scope.loading = false;
                });
            };

            $scope.updateMaterial = function(isValid) {
                if(isValid) {
                    $http.post('api/materials/'+$scope.material.id+'/edit', $scope.material)
                        .then(function(response){
                            $scope.$parent.success = response.data.msg;
                        }, function(response){
                            $scope.$parent.error = response.data;
                        });
                }
            }

            function init_editor() {
      				tinymce.init({
      					selector: '#material_text_edit',
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
      												var elm = document.getElementById('EditForm')
      												var scope = angular.element(elm).scope()
      												scope.$apply(function() {
      														$scope.material.text = editor.getContent()
      												})
      										})

                          editor.on('LoadContent', LoadWithData)
      								}
      				})
      			}

            function LoadWithData() {
              tinymce.get('material_text_edit').setContent($scope.material.text)
            }

        });

})();
