angular.module('ERP') 
.controller('RootCtrl', function($scope, $rootScope,$loading, $timeout, $http, $interval, Fullscreen, $cookieStore, $window, $state, ServerService,fileDialog,loginService) {

  $rootScope.sidebarCollapse = false;
  $scope.userRole = loginService.getUserRole();

  $scope.uploadRestoreFile = function() {
      $('#restore').modal();
  };
  
  $scope.uploadRestoreFileMysql = function(file) {
    var fileName=file[0].name;
   // alert(fileName);
    $http.get('functionFiles/testBackup.php?operType=restore&&fileName='+fileName).success(function(data) {
    //  alert(data);
    });
    $('#restore').modal('hide');
  };  

  var filepath='';
  $scope.downloadBackupFile = function() { 
    $http.get('functionFiles/testBackup.php?operType=backup').success(function(data) {
    //  alert(JSON.stringify(data));  
      var ip = location.host;            
      var filepath = data['filename'];
      //alert(filepath);
      window.open('http://' + ip + '/crm/functionFiles/dbBackup/'+data['filename'], '_blank', '');
    });
  };

  $scope.checkMasterFirmRecord = function() {
    var link = "getMasterFirmRecord";
    ServerService.getDataWithSingleParameter(link).then(function(response) {
      if(response != 1){
        $state.go("root.masterFirmAddition");
      } else {
        $state.go("root.error");
      }
    });
  };
  
  $scope.toggleSidebar = function() {
    $rootScope.sidebarCollapse = !$rootScope.sidebarCollapse;
  };

  $scope.logout=function(){
    loginService.logout();
    $cookieStore.remove('branch_name');
    $cookieStore.remove("role");
    $cookieStore.remove("fullname");
    $cookieStore.remove("username");
    $cookieStore.remove("mobno");

    swal("Logout Successfully...","","success");
  };

  $scope.userData = {};
  $scope.loadUser = function() {
    $scope.userData.userName = loginService.getUserName();
    $scope.userData.userRoleId = loginService.getUserRoleId();
    $scope.userData.userRole = loginService.getUserRole(); 
    $scope.userData.userFullName = loginService.getFullName(); 
    $scope.userData.deptId = loginService.getDeptId();
    $scope.userData.deptName = loginService.getDeptName();
    $scope.userData.mobileNumber = loginService.getMobNumber();
  };

  $scope.loadUser();

  $interval(function(){
  }, 60000);

  $scope.allNotiDetails = [];

  $scope.goFullscreen = function() {
    if (Fullscreen.isEnabled())
      Fullscreen.cancel();
    else
      Fullscreen.all();
  }

  $scope.selectedMenu = 'dashboard';
  $scope.collapseVar = 0;
  $scope.multiCollapseVar = 0;


  $scope.check = function(x) {
    if (x == $scope.collapseVar)
      $scope.collapseVar = 0;
    else
      $scope.collapseVar = x;   
  };

  // $scope.setCollapse = function(){
  //   switch($scope.userRole){
  //     case 'CC' : $scope.collapseVar = 1; break;
  //     case 'b' : $scope.collapseVar = 1; break;
  //     case 'c' : $scope.collapseVar = 2; break;
  //     case 'd' : $scope.collapseVar = 3; break;
  //     case 'e' : $scope.collapseVar = 4; break;
  //     case 'f' : $scope.collapseVar = 5; break;
  //     case 'g' : $scope.collapseVar = 7; break;
  //   }
  // }
  
  $scope.multiCheck = function(y) {
    if (y == $scope.multiCollapseVar)
      $scope.multiCollapseVar = 0;
    else
      $scope.multiCollapseVar = y;
  };

  $scope.HeaderCount = {};
  $scope.MaterialCount = {};
  ///$scope.HeaderCount.indent_count = {};
  $scope.getCountForHeader = function() {
    $http.get('functionFiles/getHeaderData.php?operType=getPendingIndent').success(function(data) {
      $scope.HeaderCount.indent_count=data[0].indent_count;
      //console.log(JSON.stringify($scope.HeaderCount));
    });

    $http.get('functionFiles/getHeaderData.php?operType=getMaterialExpiry').success(function(data) {
      $scope.MaterialCount.material_count=data[0].material_count;
      //console.log(JSON.stringify($scope.MaterialCount));
    });
  };
  
  // $scope.expireMaterialList = {};
  // $scope.getExpireMaterialList = function() {// get product List for complaint close 
  //   $loading.start('loader');
  //   $http.get('functionFiles/getHeaderData.php?operType=getExpireMaterialList').success(function(expireMaterialList) {
  //     $scope.expireMaterialList = expireMaterialList;
  //     console.log($scope.expireMaterialList);
  //     $loading.finish('loader');
  //   });
  // };

  $scope.expireMaterialList = {};
  $scope.getExpireMaterialList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getHeaderData.php?operType=getExpireMaterialList').success(function(expireMaterialList) {
      $scope.expireMaterialList = expireMaterialList;
      //console.log($scope.expireMaterialList);
      $loading.finish('loader');
    });
  };

$scope.getRoleList = {};
  $scope.getRoleList = function() {
    $loading.start('loader');
    $scope.user= loginService.getUserName();
    $scope.userRole=loginService.getUserRole();
   // alert("gggg"+$scope.userRole);
    //alert($scope.user);
    $http.get('functionFiles/getMaster.php?operType=getRoleList&&user_name='+$scope.user+'&&user_role='+$scope.userRole).success(function(RoleList) {
      $scope.Role= RoleList;
       

    //  console.log(userData.userName);
   
    angular.forEach($scope.Role,function(it){
   
    
        $scope.masterdata = it.master_data_access;
     //  alert($scope.masterdata);
        $scope.inventory_access = it.inventory_access;
        $scope.indent_access = it.indent_access;
        $scope.gate_entry_access= it.gate_entry_access;
        $scope.material_receipt_access= it.material_receipt_access;
        $scope.material_rejection_access = it.material_rejection_access;
        $scope.material_issue_access = it.material_issue_access;
        $scope.material_transfer_note_access = it.material_transfer_note_access;
        $scope.material_return_access = it.material_return_access;
        $scope.reports_access = it.reports_access;
        
    })

      $loading.finish('loader');
    });
  };

  

})