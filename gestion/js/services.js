'use strict';



/* Services */





// Demonstrate how to register services

angular.module('app.services', []);
app.factory('restaurants', ['$http', function ($http) { //restaurants:name factory on utilise in controller (declarer)
  var path =API_PATH+'restaurant/admin_list';
  var restaurant = $http.get(path).then(function (resp) {
    return resp.data.aaData;
  });

  var factory = {};
  factory.all = function () {
    return restaurant;
  };
  factory.get = function (id) {
    return restaurant.then(function(restaurant){
      for (var i = 0; i < restaurant.length; i++) {
        if (restaurant[i].id == id) return restaurant[i];
      }
      return null;
    })
  };
    factory.editer = function (id,data) {
    return restaurant.then(function(restaurant){
      for (var i = 0; i < restaurant.length; i++) {
        if (restaurant[i].id == id) return restaurant[i]=data;
      }
      return null;
    })
  };
  return factory;
}]);
app.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);
        return $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
    }
}]);