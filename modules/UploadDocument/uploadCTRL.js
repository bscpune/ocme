angular.module('uploadCTRL', [])
.config(function($stateProvider) {
  $stateProvider

  .state('home.upload', {
    url: '/upload',
    templateUrl: "modules/UploadDocument/upload.html",
    controller:'uploadCTRLs'
  })


  .state('home.view', {
    url: '/view',
    templateUrl: "modules/UploadDocument/view.html",
    controller:'uploadCTRLs'
  })

});

app.directive('fileModel', ['$parse', function ($parse) {
  return {
    restrict: 'A',
    link: function(scope, element, attrs) {
      var model = $parse(attrs.fileModel);
      var modelSetter = model.assign;
      element.bind('change', function(){
        scope.$apply(function(){
          modelSetter(scope, element[0].files[0]);
        });
      });
    }
  };
}]);
app.service('fileUpload', ['$http', function ($http,SweetAlert) {
  this.uploadFileToUrl = function(file, uploadUrl){
    var fd = new FormData();
    fd.append('file', file);
    $http.post(uploadUrl, fd, {
      transformRequest: angular.identity,
      headers: {'Content-Type': undefined}
    })
    .success(function(response){

      swal(JSON.stringify(response['MESSAGE']),'','success');
        //alert(JSON.stringify(response['MESSAGE']));
    })
    .error(function(){
      
    });
  }
}]);

 app.controller('uploadCTRLs',function($http, $scope, ServerService, $window, DTOptionsBuilder, $loading, loginService, $filter, $stateParams, $location, Excel, $timeout,fileUpload,SweetAlert) {
  $scope.productList = [];
            $scope.getProductList = function() {// get Product List
              $loading.start('loader');
              $http.get('functionFiles/getMaster.php?operType=getProductList').success(function(data) {
                $scope.productList = data;
                $loading.finish('loader');
              });
            };
            $scope.prodsubcatList = [];
            $scope.getProdSubCatist = function(PROD_DIV_CODE) { // get product Subcategory List
              $loading.start('loader');
              $http.get('functionFiles/getMaster.php?operType=getProdSubCatist&&PROD_DIV_CODE='+PROD_DIV_CODE).success(function(data) {
                $scope.prodsubcatList = data;
                $loading.finish('loader');
              });
            };
            $scope.prdModelList = [];
        $scope.getModelList = function(CODE) {// get product List for complaint close 
          $loading.start('loader');
          $http.get('functionFiles/getHOMaster.php?operType=getModelList&&CODE='+CODE).success(function(data) {
            $scope.prdModelList = data;
            $loading.finish('loader');
          });
        };        
        $scope.spPrtNames = [];
        $scope.getSPPrtNameList = function(IV_CHAR1,IV_CHAR2) {// get product List for complaint close 
          $loading.start('loader');
          $http.get('functionFiles/getHOMaster.php?operType=getSPPrtNameList&&IV_CHAR1='+IV_CHAR1+'&&IV_CHAR2='+IV_CHAR2).success(function(data) {
            $scope.spPrtNames = data;
            $loading.finish('loader');
          });
        };      
        $scope.SparePartColors = [];
      $scope.getMslPartColor = function(PART_NAME) {  //get color list against partname
        $loading.start("loader");
        $scope.SparePartColors = [];
        angular.forEach($scope.spPrtNames,function(it){
          if(PART_NAME == it.PART_NAME){
            $scope.SparePartColors.push({
              'PART_CODE': it.PART_CODE,
              'PART_COLOR': it.PART_COLOR
            });
            $loading.finish("loader");
          }
        });
      };         
      $scope.myFile = {};
      $scope.uploadFile = function(){
        $loading.start('loader');
        $scope.upload.IV_KUNNR = loginService.getASC();     
                var formDataJson = JSON.stringify($scope.upload);
            var result = $.ajax({
          method: 'GET',
          url: 'modules/UploadDocument/post.php?operType=createDirectory',
          data: {
            'formDataJson': formDataJson

          }
        }).success(function(data, status, headers, config) {
               
          $loading.finish('loader');
          return data;
        });
               var file = $scope.myFile;
              var uploadUrl = 'modules/UploadDocument/post.php?operType=uploadFile&&formDataJson=' + formDataJson + '';
             var msg = fileUpload.uploadFileToUrl(file, uploadUrl,formDataJson,msg); 
              
      };


      $scope.viewFile = function(){   
       $scope.viewDirectoryList = [];
          $loading.start('loader');
        $scope.upload.IV_KUNNR = loginService.getASC();     
                var formDataJson = JSON.stringify($scope.upload);
            var result = $.ajax({
          method: 'GET',
          url: 'modules/UploadDocument/view.php?operType=viewDirectory',
          data: {
            'formDataJson': formDataJson
          }
        }).success(function(data, status, headers, config) {
         
          $scope.viewDirectoryList = data;
          $loading.finish('loader');
                          });  
      };
    });

