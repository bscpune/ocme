angular.module('ERP').controller('LoginCtrl', ['$scope', 'ServerService', '$http', '$loading','$location','$state', 'loginService', function($scope, ServerService, $http, $loading, $location, $state, loginService) {
var routespermission;    
$scope.login = function(formJsonData) {
     loginService.login(formJsonData,$scope); //call login service
    };
}]);
