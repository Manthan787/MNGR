(function(){
    angular.module('adminApp')
        .service('Authaid', function(){

            this.getName = function(){
                var user = JSON.parse(sessionStorage.user);
                return user.firstname + " " + user.lastname;
            }
            this.isAdmin = function(){
                var user = JSON.parse(sessionStorage.user);
                if(user.role_id == 1)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }

            this.isTeacher = function(){
                var user = JSON.parse(sessionStorage.user);
                if(user.role_id == 2)
                {
                    return true;
                }
                return false;
            }

            this.isAccountant = function(){
                var user = JSON.parse(sessionStorage.user);
                if(user.role_id == 3)
                {
                    return true;
                }
                return false;
            }

            this.isStudent = function(){
                var user = JSON.parse(sessionStorage.user);
                if(user.role_id == 4)
                {
                    return true;
                }
                return false;
            }

            this.getStatus = function() {
                var user = JSON.parse(sessionStorage.user);
                return user.role_id;
            }

            this.getPosition = function(){
                var user = JSON.parse(sessionStorage.user);
                var roleID = user.role_id;
                switch(roleID){
                    case 1:
                        return 'Administrator';
                        break;
                    case 2:
                        return 'Teacher';
                        break;
                    case 3:
                        return 'Accountant';
                        break;
                    case 4:
                        return 'Student';
                        break;
                    default:
                        return null;
                }

            }
        });
})();