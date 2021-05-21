var app = angular.module('App', []);

app.controller('mainController', function($scope, $http) {

    $http({
        method: 'GET',
        url: 'https://cefis.com.br/api/v1/event'
    }).success(function(res){
        console.log(res);
        $scope.api = res.data;
    }).error(function(){
        console.log('error');
    });

    $scope.loadmore = true;
    $scope.limit = 3;
});
