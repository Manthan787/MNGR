(function(){
    angular.module('User',[])
        .factory('User', function($http){

            var User = function(data){
                angular.extend(this, data);

            }

            User.prototype.save = function(){
                var user = this;
                return $http.post('/api/members/add', user)
                        .then(function(response){
                            console.log(response);
                            return response.data.msg;
                        });

            }

            return User;
        });
})();