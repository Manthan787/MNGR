(function(){
	var app = angular.module('Settings');

	app.factory('Standard',function($http){

		var Standard = function(data){
			angular.extend(this, data);
		}

		Standard.getAll = function(){
			return $http.get('/api/Standards/all').then(function(response){
				var standards = [];
				for(var i = 0; i<response.data.length; i++)
				{
					standards.push(new Standard(response.data[i]));
				}
				return standards;
			});
		};

		Standard.prototype.get = function(){
			return $http.get('/api/Standards/'+this.id).then(function(response){
				return new Standard(response.data);
			})
		}
		Standard.prototype.add = function(){
			var standard = this;
			console.log(standard);
			return $http.post('/api/Standards/add', standard).then(function(response){
				return {standard: standard, msg: response.data.msg};
			});
		}

		Standard.prototype.edit = function(){
			var standard = this;
			return $http.post('/api/Standards/'+standard.id+'/edit', standard).then(function(response){
				return {standard: standard, msg: response.data.msg};
			});
		}

		Standard.prototype.remove = function(){
			console.log(this);
			var standard = this;
			return $http.post('/api/Standards/delete', standard).then(function(response){
				return response.data.msg;
			});
		}

		return Standard;
	});
})();
