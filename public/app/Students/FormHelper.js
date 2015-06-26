(function (){
    var app = angular.module('Students');

    app.service('FormHelper', function($http){

        this.getMediums = function(){

           return $http.get('/api/mediums').then(function(response){
                return response.data;
            });

        }

        this.getStandards = function(){
            return $http.get('/api/Standards/all').then(function(response){
                return response.data;
            });
        }

        this.getSubjects = function(){
            return $http.get('/api/Subjects/all').then(function(response){
                return response.data;
            });
        }

        this.findCurrentStandard = function(id, standards){
            for(var i=0; i<standards.length; i++)
            {
                if(standards[i].id === id)
                {
                    return standards[i];
                }
            }
        }

        this.getSubjectsByStream = function(StreamID){
            return $http.get('/api/Streams/'+StreamID+'/Subjects/all')
                .then(function(response){
                    return response.data;
                });
        }

        this.getSubjectsByStd = function(StdID, standards){

            for(var i = 0; i < standards.length; i++)
            {
                if(standards[i].id === StdID)
                {
                    return standards[i].subjects;
                }
            }
        }

        this.calculateFees = function(subjects){
            var fees = 0.00;
            for(var i = 0; i < subjects.length; i++)
            {
                fees += parseFloat(subjects[i].fees);
            }
            return fees;
        }

        this.loadStreams = function(std)
        {
            if(std && std != 'null' && std != 'undefined')
            {
                if(std!=null && std.streams[0])
                {
                    return std.streams;
                }
                else
                {
                    return false;
                }
            }
            else {
                return null;
            }

        }

    });
})();