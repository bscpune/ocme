var app = angular.module('ERP', [
    'ngCookies',
    'ui.router',
    'ui.bootstrap',
    '720kb.datepicker',

  

  // 'angularjs-dropdown-multiselect',

    'datatables',
    'datatables.tabletools',
    'ngFileUpload',
    'FBAngular',//fullscreen
    'darthwade.dwLoading',//loading
    'DWand.nw-fileDialog',
    'services',
    'MasterControllers',
    'IndentControllers',
    'transactionController',
    'uploadjmcCTRL',
    'uploadCTRL',
    'ng-sweet-alert'])

app.config(function($stateProvider, $urlRouterProvider, $locationProvider) {
    /*$locationProvider.hashPrefix('');*/
    // For any unmatched url, redirect to /.
  $urlRouterProvider.otherwise("/login");
    
    $stateProvider

        .state('home', {
          templateUrl: "app/Home.html",
          controller:"RootCtrl",
        })

        .state('login', {
            url: '/login',
            templateUrl: 'app/login/login.html',
            controller: 'LoginCtrl'
        })
       
});
// app.run(function($rootScope, $location, loginService, $state, sessionService){
//   var routespermission = loginService.url();
//   $rootScope.$on('$stateChangeStart', function(){
//     var connected=loginService.islogged();
//     connected.then(function(){   
    
//     });
//   });
// });

app.run(function($rootScope, $location, loginService, $state, sessionService){
  var routespermission = loginService.url();
  console.log("routespermission"+routespermission);
  $rootScope.$on('$stateChangeStart', function(){
    var connected=loginService.islogged();
      connected.then(function(msg){
        if(msg.data != 'authentified'){
            $state.go('login');
            $location.path('/login');
        }
    });
  });
});


