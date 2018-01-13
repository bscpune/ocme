angular.module('MasterControllers', [])

.config(function($stateProvider) {
  $stateProvider

  .state('home.UserDash', {
    url:'/UserDash',
    templateUrl: 'modules/Master/UserDash.html',
    controller:'MasterCtrl'
  })

    .state('home.AddUserList', {
    url:'/AddUserList',
    templateUrl: 'modules/Master/AddUserList.html',
    controller:'MasterCtrl'
  })
    .state('home.AddRole', {
    url:'/AddRole',
    templateUrl: 'modules/Master/AddRole.html',
    controller:'MasterCtrl'
  })
    
  .state('home.ProjectMaster', {
    url:'/ProjectMaster',
    templateUrl: 'modules/Master/ProjectMaster.html',
    controller:'MasterCtrl'
  })

  .state('home.CustomerMaster', {
    url:'/CustomerMaster',
    templateUrl: 'modules/Master/CustomerMaster.html',
    controller:'MasterCtrl'
  })
 
  .state('home.MasterMaterial', {
    url:'/MasterMaterial',
    templateUrl: 'modules/Master/MasterMaterial.html',
    controller:'MasterCtrl'
  })

  .state('home.VendorMaster', {
    url:'/VendorMaster',
    templateUrl: 'modules/Master/VendorMaster.html',
    controller:'MasterCtrl'
  })

  .state('home.StorageLocationMaster', {
    url:'/StorageLocationMaster',
    templateUrl: 'modules/Master/StorageLocationMaster.html',
    controller:'MasterCtrl'
  })

  .state('home.StoresMaster', {
    url:'/StoresMaster',
    templateUrl: 'modules/Master/StoresMaster.html',
    controller:'MasterCtrl'
  })

  .state('home.SiteMaster', {
    url:'/SiteMaster',
    templateUrl: 'modules/Master/SiteMaster.html',
    controller:'MasterCtrl'
  })

  .state('home.ActivityMaster', {
    url:'/ActivityMaster',
    templateUrl: 'modules/Master/ActivityMaster.html',
    controller:'MasterCtrl'
  })

  .state('home.ContractorMaster', {
    url:'/ContractorMaster',
    templateUrl: 'modules/Master/ContractorMaster.html',
    controller:'MasterCtrl'
  })


.state('home.print', {
    url:'/print',
    templateUrl: 'modules/Master/print.html',
    controller:'MasterCtrl'
  })

.state('home.InwardRegister', {
    url:'/InwardRegister',
    templateUrl: 'modules/Master/Reports/InwardRegister.html',
    controller:'MasterCtrl'
  })

.state('home.OutwardRegister', {
    url:'/OutwardRegister',
    templateUrl: 'modules/Master/Reports/OutwardRegister.html',
    controller:'MasterCtrl'
  })

.state('home.GateInwardRegister', {
    url:'/GateInwardRegister',
    templateUrl: 'modules/Master/Reports/GateInwardRegister.html',
    controller:'MasterCtrl'
  })

.state('home.GateOutwardRegister', {
    url:'/GateOutwardRegister',
    templateUrl: 'modules/Master/Reports/GateOutwardRegister.html',
    controller:'MasterCtrl'
  })

.state('home.SCStockMovementRegister', {
    url:'/SCStockMovementRegister',
    templateUrl: 'modules/Master/Reports/SCStockMovementRegister.html',
    controller:'MasterCtrl'
  })

.state('home.InwardOutwardRegister', {
    url:'/InwardOutwardRegister',
    templateUrl: 'modules/Master/Reports/InwardOutwardRegister.html',
    controller:'MasterCtrl'
  })

.state('home.DetailedStock', {
    url:'/DetailedStock',
    templateUrl: 'modules/Master/Reports/DetailedStock.html',
    controller:'MasterCtrl'
  })

.state('home.ActivityTransaction', {
    url:'/ActivityTransaction',
    templateUrl: 'modules/Master/ActivityTransaction.html',
    controller:'MasterCtrl'
  })

.state('home.UnitOfMeasurement', {
    url:'/UnitOfMeasurement',
    templateUrl: 'modules/Master/UnitOfMeasurement.html',
    controller:'MasterCtrl'
  })

})

app.directive("fileInput", function($parse){  
      return{  
           link: function($scope, element, attrs){  
                element.on("change", function(event){  
                     var files = event.target.files;  
                     console.log(files[0].name);  
                     $parse(attrs.fileInput).assign($scope, element[0].files);  
                     $scope.$apply();  
                });  
           }  
      }  
 });

app.controller('MasterCtrl', function($http, $state, $scope,$cookieStore, ServerService, $window, DTOptionsBuilder, $loading, loginService, $filter, $stateParams, $location, Excel, $timeout,SweetAlert,fileUpload,$interval) {
  $scope.dtOptions = DTOptionsBuilder.fromFnPromise(function() {})
  .withTableTools('components/angular-datatables-master/vendor/datatables-tabletools/swf/copy_csv_xls_pdf.swf')
  .withTableToolsButtons([
    'copy',
    'print', {
      'sExtends': 'collection',
      'sButtonText': 'Save',
      'aButtons': ['csv', 'xls', 'pdf']
    }
  ]);
  
  /*===============================export to excel==========================================*/
  $scope.exportToExcel=function(tableId,sheetname){ // ex: '#my-table'
    $scope.exportHref=Excel.tableToExcel(tableId,'sheetname');
    $scope.date = $filter("date")(new Date(), 'dd-MM-yyyy');
    $timeout(function(){
      var link = document.createElement('a');
      link.download = sheetname+" on"+$scope.date+".xlsx";
      link.href=$scope.exportHref;
      link.click();
    },100);
  };

  $scope.reload=function(){
    $window.history.back();
  }
  
  $scope.userRoleId = loginService.getUserRoleId();
  $scope.userRole = loginService.getUserRole();

  /*****************  Amit code starts here  ********************/

  $scope.parseInt = parseInt;

  $scope.dashboard = {};
  $scope.getDashboardCount = function (){
    $http.get('functionFiles/getMaster.php?operType=getIndentCount').success(function(data) {
      $scope.dashboard.indentCount = data.indentCount;
      $scope.dashboard.pendingIndentCount = data.pendingIndentCount;
      $scope.dashboard.purchaseOrderCount = data.purchaseOrderCount;
      $scope.dashboard.pendingPurchaseOrderCount = data.pendingPurchaseOrderCount;
    });
  }

  $scope.projectNameList = [];
  $scope.getProjectNameList = function(project_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getProjectNameList&&project_id='+project_id).success(function(projectNameList) {
      $scope.projectNameList = projectNameList;
      $loading.finish('loader');
    });
  };
  
$scope.countryList = [];
  $scope.getCountryList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getCountryList').success(function(countryList) {
      $scope.countryList = countryList;
      $loading.finish('loader');
    });
  };

  $scope.stateList = [];
  $scope.getStateList = function(country_name) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getStateList&&country_name='+country_name).success(function(stateList) {
      $scope.stateList = stateList;
      $loading.finish('loader');
    });
  };



  $scope.activityNameList = [];
  $scope.getActivityNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getActivityNameList').success(function(activityNameList) {
      $scope.activityNameList = activityNameList;
      console.log($scope.activityNameList);
      $loading.finish('loader');
    });
  };

  $scope.storeNameList = [];
  $scope.getStoreNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getStoreNameList').success(function(storeNameList) {
      $scope.storeNameList = storeNameList;
      $loading.finish('loader');
    });
  };

  /************** Sujata Code Starts Here***********************/

  $scope.materialNameList = [];
  $scope.getMaterialNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getMaterialNameList').success(function(materialNameList) {
      $scope.materialNameList = materialNameList;
      $loading.finish('loader');
    });
  };

   
  $scope.getInwardList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getInwardList').success(function(data) {
      $scope.inwardList=data;
      //console.log($scope.inwardList);
      $loading.finish('loader');
    });
  };

  $scope.getOutwardList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getOutwardList').success(function(data) {
      $scope.outwardList=data;
      //console.log($scope.outwardList);
      $loading.finish('loader');
    });
  };

  $scope.getStoreName1 = function(d_project_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getStoreName1&&d_project_id='+d_project_id).success(function(storeName) {
      $scope.storeName1 = storeName;
    console.log($scope.storeName1);
      $loading.finish('loader');
    });
  };

  $scope.getStoreList1 = function(project_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getStoreList1&&project_id='+project_id).success(function(storeNameList) {
      $scope.storeNameList = storeNameList;
      $loading.finish('loader');
    });
  };

$scope.getInventoryTypeList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getInventoryTypeList').success(function(inventoryTypeList) {
      $scope.inventoryTypeList = inventoryTypeList;
      $loading.finish('loader');
    });
  };
$scope.gateinwardregister={};
  $scope.getGateinwardList = function(project_id,store_id,challan_no,inventory_type_id,supplier_name,from_date,to_date){
    $loading.start('loader');
    if(project_id==undefined){
     project_id='%';
    };
     if(store_id==undefined){
     store_id='%';
    };
     if(supplier_name==undefined){
     supplier_name='%';
    };
     if(challan_no==undefined){
    challan_no='%';
     };
      if(inventory_type_id==undefined){
    inventory_type_id='%';
     };
      if(from_date==undefined){
from_date='%';
     };
       if(to_date==undefined){
to_date='%';
    };
     $http.get('functionFiles/getMaster.php?operType=getGateinwardList&&project_id='+project_id+'&&store_id='+store_id+'&&challan_no='+challan_no+'&&inventory_type_id='+inventory_type_id+'&&supplier_name='+supplier_name+'&&to_date='+to_date+'&&from_date='+from_date).success(function(gateinwardregister) {
      $scope.gateinwardregister = gateinwardregister;
      if(to_date!='%'){
      $scope.gateinwardregister.to_date=to_date;
      }
       if(from_date!='%'){
      $scope.gateinwardregister.from_date=from_date;
      }
      if(project_id!='%'){
      $scope.gateinwardregister.project_id=project_id;
      }
       if(store_id!='%'){
      $scope.gateinwardregister.store_id=store_id;
      }
      if(inventory_type_id!='%'){
      $scope.gateinwardregister.inventory_type_id=inventory_type_id;
      }
       if(challan_no!='%'){
      $scope.gateinwardregister.challan_no=challan_no;
      }
      if(supplier_name!='%'){
      $scope.gateinwardregister.supplier_name=supplier_name;
      }
          angular.forEach($scope.gateinwardregister, function(value, key){
        if(value.status == 0)        
        {
          value.status = 'In Progress';
        }
        else
        {
          value.status = 'In Transit';
        }
      });
      $loading.finish('loader');
       });
   };


$scope.gateoutwardregister={};
  $scope.getGateoutwardList = function(project_id,store_id,challan_no,inventory_type_id,supplier_name,from_date,to_date){
    $loading.start('loader');
    if(project_id==undefined){
     project_id='%';
    };
     if(store_id==undefined){
     store_id='%';
    };
     if(supplier_name==undefined){
     supplier_name='%';
    };
     if(challan_no==undefined){
    challan_no='%';
     };
      if(inventory_type_id==undefined){
    inventory_type_id='%';
     };
      if(from_date==undefined){
from_date='%';
     };
       if(to_date==undefined){
to_date='%';
    };
     $http.get('functionFiles/getMaster.php?operType=getGateoutwardList&&project_id='+project_id+'&&store_id='+store_id+'&&challan_no='+challan_no+'&&inventory_type_id='+inventory_type_id+'&&supplier_name='+supplier_name+'&&to_date='+to_date+'&&from_date='+from_date).success(function(gateoutwardregister) {
      $scope.gateoutwardregister = gateoutwardregister;
      if(to_date!='%'){
      $scope.gateoutwardregister.to_date=to_date;
      }
       if(from_date!='%'){
      $scope.gateoutwardregister.from_date=from_date;
      }
      if(project_id!='%'){
      $scope.gateoutwardregister.project_id=project_id;
      }
       if(store_id!='%'){
      $scope.gateoutwardregister.store_id=store_id;
      }
      if(inventory_type_id!='%'){
      $scope.gateoutwardregister.inventory_type_id=inventory_type_id;
      }
       if(challan_no!='%'){
      $scope.gateoutwardregister.challan_no=challan_no;
      }
      if(supplier_name!='%'){
      $scope.gateoutwardregister.supplier_name=supplier_name;
      }
          angular.forEach($scope.gateoutwardregister, function(value, key){
        if(value.status == 0)        
        {
          value.status = 'In Progress';
        }
        else
        {
          value.status = 'In Transit';
        }
      });
      $loading.finish('loader');
       });
  };


  $scope.scstockmovementregister={};
  $scope.getScstockmovementregisterList = function(from_date,to_date) {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getScstockmovementregisterList&&from_date='+$scope.scstockmovementregister.from_date+'&&to_date='+$scope.scstockmovementregister.to_date).success(function(data) {
      $scope.scstockmovementregisterList=data;
      //console.log($scope.outwardList);
      $loading.finish('loader');
    });
  };

// $scope.getInwardoutwardList = function() {
//     $loading.start('loader');
//     $http.get('functionFiles/getMaster.php?operType=getInwardoutwardList').success(function(data) {
//       $scope.inwardoutwardList=data;
//       //console.log($scope.outwardList);
//       $loading.finish('loader');
//     });
//   };


  $scope.detailedstock={};
  $scope.getDetailedstockList = function(from_date,to_date) {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getDetailedstockList&&from_date='+$scope.detailedstock.from_date+'&&to_date='+$scope.detailedstock.to_date).success(function(data) {
      $scope.detailedstockList=data;
      //console.log($scope.outwardList);
      $loading.finish('loader');
    });
  };

$scope.inwardouteardregister={};
  $scope.getinwardoutwardList = function(from_date,to_date) {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getinwardoutwardList&&from_date='+$scope.gateinwardregister.from_date+'&&to_date='+$scope.gateinwardregister.to_date).success(function(data) {
      //$scope.gateinwardregister.from_date = $filter('date')(data.from_date, 'DD-MM-YYYY');
      //$scope.gateinwardregister.to_date = $filter('date')(data.to_date, 'DD-MM-YYYY');
      $scope.inwardoutwardList = data;

      //console.log($scope.gateinwardList);
      //console.log($scope.gateinwardregister.from_date);
      //console.log($scope.gateinwardregister.to_date);

      angular.forEach($scope.inwardoutwardList, function(value, key){
        if(value.status == 0)        
        {
          value.status = 'In Progress';
        }
        else
        {
          value.status = 'In Transit';
        }
      });
      //console.log($scope.outwardList);
      $loading.finish('loader');

      angular.forEach($scope.inwardoutwardList, function(value, key){
        if(value.inventory_type_id == 1)        
        {
          value.inventory_type_id = 'Emco Stock';
        }
        else if (value.inventory_type_id == 2)
        {
          value.inventory_type_id = 'OSM Stock';
        }
        else{
          value.inventory_type_id = 'T & P Stock';
        }
      });
      $loading.finish('loader');
    });
  };

$scope.orderByMe = function(customer) {
        $scope.myOrderBy = customer;
    }
  /*****************  amit w code starts here  ********************/

  //Customer Master
  $scope.customer ={};
  $scope.addCustomerForm = false;
  $scope.showAddCustomerForm = function() {
    $scope.addCustomerForm = true;
    $scope.addCustomerData = true;
    $scope.updateCustomerData = false;
    $scope.customer = {};
    $scope.customer.customer_code = '';
    $scope.customer.customer_name = '';
    $scope.customer.customer_sap_code = '';
    $scope.customer.address1 = '';
    $scope.customer.address2 = '';
    $scope.customer.address3 = '';
    $scope.customer.city = '';
    $scope.customer.pin_code = '';
    $scope.customer.state_name = '';
    $scope.customer.country_name = '';
    $scope.customer.fax_no = '';
    $scope.customer.contact_person = '';
    $scope.customer.contact_no = '';
    $scope.customer.email_id = '';
    $scope.customer.pan_no = '';
    $scope.customer.gst_no = '';

    var customerCode;
    $http.get('functionFiles/getMaster.php?operType=getCustomerCode').success(function(data) {
      var str = data.replace(/\s+/g, '');
      if(str == ''){
        customerCode = 'C0001';
      } else {
        var codeNumber = parseInt(str.slice(1)) + 1;
        var customerCodeInString = codeNumber.toString();

        if(customerCodeInString.length == 1){
          customerCode = 'C000' + customerCodeInString;
        }else if(customerCodeInString.length == 2){
          customerCode = 'C00' + customerCodeInString;
        }else if(customerCodeInString.length == 3){
          customerCode = 'C0' + customerCodeInString;
        } else {
          customerCode = 'C' + customerCodeInString;
        }
      }
      $scope.customer.customer_code = customerCode;
    });
  };

  $scope.hideAddCustomerForm = function() {
    $scope.addCustomerForm = false;
    $scope.updateCustomerData = false;
    $scope.customer = {};
  };

  $scope.customerList = [];
  $scope.getCustomerList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getCustomerList').success(function(customerList) {
      $scope.customerList = customerList;
      //console.log( $scope.customerList);
        angular.forEach($scope.customerList, function(value, key){
          
        if(value.active_status == 0)        
        {
          value.active_status_display = 'Active';
        }
        else if(value.active_status == 1)
        {
          value.active_status_display = 'DeActive';
        }
      });
      $loading.finish('loader');
    });
  };

  $scope.saveCustomer = function(fromAddCustomer){
    $loading.start('loader');
    if(fromAddCustomer){
      
          $scope.customer.created_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.customer);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveCustomer',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            $scope.hideAddCustomerForm();
            $scope.getCustomerList();
            if(data == 1){
              SweetAlert.swal("Customer Added Successfully...","","success");
            }else {
              SweetAlert.swal("Error In Adding Customer...","","error");
            }      
          });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.getCustomerDetails = function(customer_id){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getCustomerDetails&&customer_id='+customer_id).success(function(data) {
      $scope.addCustomerForm = true;
      $scope.addCustomerData = false;
      $scope.updateCustomerData = true;
      $scope.customer = data[0];
      $scope.getStateList(data[0].country_name);
      $scope.customer.state_name = data[0].state_name;
      $loading.finish('loader');
    });
  };

  $scope.updateCustomer = function(fromAddCustomer){
    $loading.start('loader');
    if(fromAddCustomer){
      var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateCustomerForUpdate&&customer_id='+$scope.customer.customer_id+'&&customer_name='+$scope.customer.customer_name).success(function(data) {
        count = data;
        if(count != 0){
          SweetAlert.swal("Customer Already Exist...","","warning");
          $loading.finish('loader');
        }else{
          $scope.customer.updated_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.customer);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=updateCustomer',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 0){
              SweetAlert.swal("Error In Updating customer...","","error");
            }else {
              SweetAlert.swal("Customer Updated Successfully...","","success");
            }  
            $scope.hideAddCustomerForm();
            $scope.getCustomerList();
          });
        }
      });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

$scope.deleteCustomer = function(customer_id,active_status){
    $loading.start('loader');
    $scope.customer.customer_id = customer_id;
     $scope.customer.active_status = active_status;
    $scope.customer.deleted_by = loginService.getUserName();
    var formDataJson = JSON.stringify($scope.customer);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveMasterRecords.php?operType=deleteCustomer',
      data: {
        'formDataJson': formDataJson
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getCustomerList();
      if(data==1){
        SweetAlert.swal("Customer Status Changed Successfully...","","success");
      } else {
        SweetAlert.swal("Error In Deleting Customer...","","error");
      }      
    });
  };

        //Project Master
     $scope.project = {};
     $scope.addProjectForm = false;
     $scope.showAddProjectForm = function() {
    $scope.addProjectForm = true;
    $scope.addProjectData = true;
    $scope.project = {};    
    $scope.project.project_code = '';
    $scope.project.project_name = '';
    $scope.project.manager_name = '';
    $scope.project.email_id = '';
    $scope.project.contact_no = '';
    $scope.project.start_date = '';
    $scope.project.end_date = '';
    $scope.project.city = '';
    $scope.project.state_name = '';
    $scope.project.country_name = '';
    $scope.project.wbs = '';
    $scope.project.plant_name = '';
    $scope.project.project_location = '';
    $scope.project.address2 = '';
    $scope.project.pin_code = '';
    $scope.project.address3 = ''; 
    $scope.project.address1 = '';
   
    //$scope.project.start_date = $filter('date')(new Date(), 'dd-MM-yyyy');
    //$scope.project.end_date = $filter('date')(new Date(), 'dd-MM-yyyy');

    var projectCode;
    $http.get('functionFiles/getMaster.php?operType=getProjectCode').success(function(data) {
      var str = data.replace(/\s+/g, '');
      if(str == ''){
        projectCode = 'P0001';
      } else {
        var codeNumber = parseInt(str.slice(1)) + 1;
        var projectCodeInString = codeNumber.toString();

        if(projectCodeInString.length == 1){
          projectCode = 'P000' + projectCodeInString;
        }else if(projectCodeInString.length == 2){
          projectCode = 'P00' + projectCodeInString;
        }else if(projectCodeInString.length == 3){
          projectCode = 'P0' + projectCodeInString;
        } else {
          projectCode = 'P' + projectCodeInString;
        }
      }
      $scope.project.project_code = projectCode;
    });
  };

  $scope.hideAddProjectForm = function() {
    $scope.addProjectForm = false;
    //$scope.addProjectData = false;
    $scope.project = {};
  };

$scope.projectList = [];
  $scope.getProjectList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getProjectList').success(function(projectList) {
      $scope.projectList = projectList;
      //console.log( $scope.customerList);
        angular.forEach($scope.projectList, function(value, key){
          if(value.active_status == 0)        
        {
          value.active_status_display = 'Active';
        }
        else if(value.active_status == 1)
        {
          value.active_status_display = 'DeActive';
        }
         });
      $loading.finish('loader');
    });
  };

  $scope.getProjectDetails = function(project_id){
    $http.get('functionFiles/getMaster.php?operType=getProjectDetails&&project_id='+project_id).success(function(data) {
     
      $scope.project = data[0];
       $scope.getStateList(data[0].country_name);
      $scope.project.state_name = data[0].state_name;
    $scope.addProjectForm = true;
      $scope.addProjectData = false;
    });
  };

   $scope.saveProject = function(fromAddProject){
    $loading.start('loader');
    if(fromAddProject){

     
   var dateone = $scope.project.start_date;
   var datetwo =$scope.project.end_date;
var year1 = dateone.substr(6, 9);
var year2 = datetwo.substr(6, 9);
var month1= dateone.substr(3,2);
var month2= datetwo.substr(3,2);
var day1 = dateone.substr(0,2);
var day2 = datetwo.substr(0,2);
$http.get('functionFiles/getMaster.php?operType=checkDuplicateProject&&project_name='+$scope.project.project_name).success(function(data) {
count = data;
if(count != 0){
SweetAlert.swal("Project Name Already Exist...","","warning");
$loading.finish('loader');
}else if(year1>year2){
 SweetAlert.swal("Project End Date Should Be >= Project Start Date...","","warning");
     $loading.finish('loader');
}else if(year1==year2 && month1>month2){
 SweetAlert.swal("Project End Date Should Be >= Project Start Date...","","warning");
     $loading.finish('loader');
}else if(year1==year2 && month1==month2&& day1>day2){
 SweetAlert.swal("Project End Date Should Be >= Project Start Date...","","warning");
     $loading.finish('loader');
}else{
    $scope.project.created_by = loginService.getUserName();      
      var formDataJson = JSON.stringify($scope.project);
      var result = $.ajax({
        method: 'POST',
        url: 'functionFiles/saveMasterRecords.php?operType=saveProject',
        data: {
          'formDataJson': formDataJson
        }
      }).success(function(data, status, headers, config) {
        $loading.finish('loader');
          $scope.hideAddProjectForm();
          $scope.getProjectList();
          if(data != 0){
          SweetAlert.swal("Project Added Successfully...","","success");
        }else {
          SweetAlert.swal("Error In Adding Project...","","Error");
        }      
      });
    }
    });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

   $scope.updateProject = function(fromAddProject){
    $loading.start('loader');
    if(fromAddProject){
       var dateone = $scope.project.start_date;
   var datetwo =$scope.project.end_date;
var year1 = dateone.substr(6, 9);
var year2 = datetwo.substr(6, 9);
var month1= dateone.substr(3,2);
var month2= datetwo.substr(3,2);
var day1 = dateone.substr(0,2);
var day2 = datetwo.substr(0,2);
// var count = 0;
 $http.get('functionFiles/getMaster.php?operType=checkDuplicateProject&&project_name='+$scope.project.project_name).success(function(data) {
count = data;
/*if(count != 0){
SweetAlert.swal("Project Name Already Exist...","","warning");
$loading.finish('loader');
}else*/ if(year1>year2){
 SweetAlert.swal("Project End Date Should Be >= Project Start Date...","","warning");
     $loading.finish('loader');
}else if(year1==year2 && month1>month2){
 SweetAlert.swal("Project End Date Should Be >= Project Start Date...","","warning");
     $loading.finish('loader');
}else if(year1==year2 && month1==month2&& day1>day2){
 SweetAlert.swal("Project End Date Should Be >= Project Start Date...","","warning");
     $loading.finish('loader');
}else{
          $scope.project.updated_by = loginService.getUserName();
      //$scope.project.active_status = 0;
      var formDataJson = JSON.stringify($scope.project);
      console.log(JSON.stringify($scope.project));
      var result = $.ajax({
        method: 'POST',
        url: 'functionFiles/saveMasterRecords.php?operType=updateProject',
        data: {
          'formDataJson': formDataJson
        }
      }).success(function(data, status, headers, config) {
        $loading.finish('loader');
        if(data!= 0){
          $scope.hideAddProjectForm();
          $scope.getProjectList();
          $scope.project={};
          SweetAlert.swal("Project Updated Successfully...","","success");
        }else {
          SweetAlert.swal("Error In Updating project...","","error");
        }  
      });
    }
    });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

   $scope.deleteProject = function(project_id,active_status){
    $loading.start('loader');
    $scope.project.project_id = project_id;
    $scope.project.active_status = active_status;
    $scope.project.deleted_by = loginService.getUserName();
    var formDataJson = JSON.stringify($scope.project);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveMasterRecords.php?operType=deleteProject',
      data: {
        'formDataJson': formDataJson
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getProjectList();
      if(data==1){
        SweetAlert.swal("Project Status Changed Successfully...","","success");
      } else {
        SweetAlert.swal("Error In Changing Project Status...","","error");
      }      
    });
  };

  $scope.vendor = {};
  $scope.addVendorForm = false;
  $scope.showAddVendorForm = function() {
    $scope.addVendorForm = true;
    $scope.addVendorData = true;
    $scope.vendor = {};
    $scope.vendor.vendor_code = '';
    $scope.vendor.vendor_name = '';
    $scope.vendor.vendor_sap_id = '';
    $scope.vendor.address1 = '';
    $scope.vendor.address2 = '';
    $scope.vendor.address3 = '';
    $scope.vendor.state_name = '';
    $scope.vendor.country_name = '';
    $scope.vendor.pin_code = '';
    $scope.vendor.city= '';
    $scope.vendor.contact_no = '';
    $scope.vendor.contact_person = '';
    $scope.vendor.email_id = '';
    $scope.vendor.pan_details = '';
    $scope.vendor.gst_no='';

    var vendorCode;
    $http.get('functionFiles/getMaster.php?operType=getVendorCode').success(function(data) {
      var str = data.replace(/\s+/g, '');
      if(str == ''){
        vendorCode = 'V0001';
      } else {
        var codeNumber = parseInt(str.slice(1)) + 1;
        var vendorCodeInString = codeNumber.toString();
        if(vendorCodeInString.length == 1){
          vendorCode = 'V000' + vendorCodeInString;
        }else if(vendorCodeInString.length == 2){
          vendorCode = 'V00' + vendorCodeInString;
        }else if(vendorCodeInString.length == 3){
          vendorCode = 'V0' + vendorCodeInString;
        } else {
          vendorCode = 'V' + vendorCodeInString;
        }
      }
      $scope.vendor.vendor_code = vendorCode;
    });
  };

  $scope.hideAddVendorForm = function() {
    $scope.addVendorForm = false;
    $scope.vendor = {};
  };

  $scope.vendorList = [];
  $scope.getVendorList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getVendorList').success(function(vendorList) {
      $scope.vendorList = vendorList; 
       angular.forEach($scope.vendorList, function(value, key){
          
        if(value.active_status == 1)        
        {
          value.active_status_display= 'DeActive';
        }
        else if(value.active_status == 0)
        {
          value.active_status_display = 'Active';
        }
      }); 
      $loading.finish('loader');
    });
  };

  $scope.saveVendor = function(fromAddVendor){
    $loading.start('loader');
    if(fromAddVendor){
     
          $scope.vendor.created_by = loginService.getUserName();

          var formDataJson = JSON.stringify($scope.vendor);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveVendor',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            $scope.hideAddVendorForm();
            $scope.getVendorList();
            if(data == 1){
              SweetAlert.swal("Vendor Added Successfully...","","success");
            }else {
              SweetAlert.swal("Error In Adding Vendor...","","error");
            }      
          });
          }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.getVendorDetails = function(vendor_id){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getVendorDetails&&vendor_id='+vendor_id).success(function(data) {
      $scope.addVendorForm = true;
      $scope.addVendorData = false;
      $scope.vendor = data[0];
      $scope.getStateList(data[0].country_name);
      $scope.vendor.state_name = data[0].state_name;
      $loading.finish('loader');
    });
  };

  $scope.updateVendor = function(fromAddVendor){
    $loading.start('loader');
    if(fromAddVendor){
      // var count = 0;
      // $http.get('functionFiles/getMaster.php?operType=checkDuplicateVendorForUpdate&&vendor_id='+$scope.vendor.vendor_id+'&&vendor_name='+$scope.vendor.vendor_name).success(function(data) {
      //   count = data;
      //   if(count != 0){
      //     SweetAlert.swal("Vendor Already Exist...","","warning");
      //     $loading.finish('loader');
      //   }

          $scope.vendor.updated_by = loginService.getUserName();
          
          var formDataJson = JSON.stringify($scope.vendor);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=updateVendor',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 0){
              SweetAlert.swal("Error In Updating Vendor...","","error");
            }else {
              SweetAlert.swal("Vendor Updated Successfully...","","success");
            }  
            $scope.hideAddVendorForm();
            $scope.getVendorList();
          });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.deleteVendor = function(vendor_id,active_status){
    $loading.start('loader');
    $scope.vendor.vendor_id = vendor_id;
     $scope.vendor.active_status = active_status;
    $scope.vendor.deleted_by = loginService.getUserName();
    var formDataJson = JSON.stringify($scope.vendor);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveMasterRecords.php?operType=deleteVendor',
      data: {
        'formDataJson': formDataJson
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getVendorList();
      if(data == 1){
        SweetAlert.swal("Vendor Status Changed Successfully...","","success");
      }else {
        SweetAlert.swal("Error In Changing Vendor Status...","","error");
      }  
    });
  };


//Material Master
  $scope.material = {};
  $scope.addMaterialForm = false;
  $scope.showAddMaterialForm = function() {
    $scope.addMaterialForm = true;
    $scope.addMaterialData = true;
    $scope.addMaterialData1 = true;
    $scope.materialList = [];
     $scope.material.material_code = '';
     $scope.material.material_name = '';
     $scope.material.material_description = '';
     $scope.material.material_type = '';
     $scope.material.unit_of_measurment = '';
     $scope.material.unit_price = '';
     $scope.material.min_quantity = '';
     $scope.material.max_quantity = '';
     $scope.material.expiry_status = '';
     $scope.material.reorder_level = '';
     $scope.material.reorder_quantity = '';
  
  $http.get('functionFiles/getMaster.php?operType=getMaterialCode').success(function(data) {
     /* var materialCode;
      var finalMaterialCode;
      var date = new Date();
      var currentDay = date.getDay();
      var currentMonth = date.getMonth() + 1;
      var currentYear = date.getFullYear().toString().substr(-2);
      var nextYear = parseInt(currentYear) + 1;
      var previousYear = parseInt(currentYear) - 1;
      if(data.trim() == ''){
        if(currentMonth == 1 || currentMonth == 2 || currentMonth == 3){
          finalMaterialCode = 'M-1/' + previousYear + '-' + currentYear;
        } else {
          finalMaterialCode = 'M-1/' + currentYear + '-' + nextYear;
        }
      } else {
        var str = data;    
        var string = str.split('/').shift().split('-').pop();
        materialCode = parseInt(string) + 1;

        if(currentMonth == 1 || currentMonth == 2 || currentMonth == 3){
          finalMaterialCode = 'M-' + materialCode + '/' + previousYear + '-' + currentYear;
        } else {
          var temp = 'M-1/' + currentYear + '-' + nextYear;
          if(currentMonth == 4 && data != temp){
            finalMaterialCode = 'M-1/' + currentYear + '-' + nextYear;
          } else {
            finalMaterialCode = 'M-' + materialCode + '/' + currentYear + '-' + nextYear;
          }
        }
      }
      $scope.material.material_code = finalMaterialCode;*/
      $scope.material.material_date = $filter('date')(new Date(), 'dd-MM-yyyy');
      $scope.material.material_name = '';
      $scope.material.material_description = '';
       $scope.material.secondary_uom = '';
      $scope.material.material_type = '';
      $scope.material.unit_of_measurment = '';
      $scope.material.unit_price = '';
      $scope.material.min_quantity = '';
      $scope.material.max_quantity = '';
      $scope.material.expiry_status = '';
      $scope.material.reorder_level = '';
      $scope.material.reorder_quantity = '';     
    });
  }

  $scope.hideAddMaterialForm = function() {
    $scope.addMaterialForm = false;
    $scope.getMaterialList();
    $scope.material = {};
  };

  $scope.materialList = [];
  $scope.getMaterialList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getMaterialList').success(function(materialList) {
      $scope.materialList = materialList;
       angular.forEach($scope.materialList, function(value, key){
          if(value.active_status == 0)        
        {
          value.active_status_display = 'Active';
        }
        else if(value.active_status == 1)
        {
          value.active_status_display = 'DeActive';
        }
         });      $loading.finish('loader');
    });
  };

  $scope.getMaterialDetails = function(material_id){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getMaterialDetails&&material_id='+material_id).success(function(data) {
      $scope.addMaterialForm = true;
      $scope.addMaterialData = false;
      $scope.addMaterialData1 = true;
      $scope.material={};
      $scope.material.material_description = '';
       $scope.material.secondary_uom = '';
      $scope.material.material_type = '';
      $scope.material.unit_of_measurment = '';
      $scope.material.unit_price = '';
      $scope.material.min_quantity = '';
      $scope.material.max_quantity = '';
      $scope.material.expiry_status = '';
      $scope.material.reorder_level = '';
      $scope.material.reorder_quantity = '';
      $scope.material = data[0];
      $scope.material.min_quantity = parseInt(data[0].min_quantity);
      $scope.material.max_quantity = parseInt(data[0].max_quantity);
      $loading.finish('loader');
    });
  };

  $scope.saveMaterial = function(fromAddMaterial){
    $loading.start('loader');
    if(fromAddMaterial){
      var str = $scope.material.material_code;
      var n = str.length; 
      var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateMaterial&&material_code='+$scope.material.material_code).success(function(data) {
        count = data;
        if(count != 0){
          SweetAlert.swal("Material Code Already Exist...","","warning");
          $loading.finish('loader');
        }else if(n!=18){
          SweetAlert.swal("Material Code Should Be 18 Digit...","","warning");
          $loading.finish('loader');
        } else {
          $scope.material.created_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.material);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveMaterial',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 1){
              $scope.hideAddMaterialForm();
               $scope.getMaterialList();
              SweetAlert.swal("Material Added Successfully...","","success");
            } else {
              SweetAlert.swal("Error In Adding Material...","","error");
            }      
          });
        }
      });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.updateMaterial = function(fromAddMaterial){
    $loading.start('loader');
    if(fromAddMaterial){
          $scope.material.updated_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.material);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=updateMaterial',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data !=0){
              SweetAlert.swal("Material Updated Successfully...","","success");
            } else {
              SweetAlert.swal("Error In Updating Material...","","error");
            }
            $scope.hideAddMaterialForm();
            $scope.getMaterialList();
          }); 
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.deleteMaterial = function(material_id,active_status){
    $loading.start('loader');
    $scope.material.material_id = material_id;
    $scope.material.active_status = active_status;
    $scope.material.deleted_by = loginService.getUserName();
    var formDataJson = JSON.stringify($scope.material);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveMasterRecords.php?operType=deleteMaterial',
      data: {
        'formDataJson': formDataJson
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getMaterialList();
      if(data==1){
        SweetAlert.swal("Material Status Changed Successfully...","","success");
      } else {
        SweetAlert.swal("Error In Changing Material Status ...","","error");
      }      
    });
  };

  $scope.addUOMForm = false;
  $scope.showAddUOMForm = function() {
    $scope.addUOMForm = true;
    $scope.addUOMData = true;
    $scope.uom = {};
    $scope.uom.uom_name = '';
    $scope.uom.uom_description = '';
  };
  $scope.hideAddUOMForm = function() {
    $scope.addUOMForm = false;
    $scope.uom = {};
  };

    $scope.saveUOM = function(fromAddUOM){
    $loading.start('loader');
    if(fromAddUOM){
          //$scope.uom.created_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.uom);
          console.log($scope.uom);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveUOM',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
        //console.log(data);
            if(data == 1){
              $scope.hideAddUOMForm();
              $scope.getUOMList();
              SweetAlert.swal("UOM Added Successfully...","","success");
            }else {
              SweetAlert.swal("Error In Adding UOM...","","error");
            }      
          });
      
      
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.uomList = [];
  $scope.getUOMList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getUOMList').success(function(uomList) {
      $scope.uomList = uomList;
      $loading.finish('loader');
    });
  };

  $scope.getUOMDetails = function(uom_id){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getUOMDetails&&uom_id='+uom_id).success(function(data) {
      $scope.addUOMForm = true;
      $scope.addUOMData = false;
      $scope.uom = data[0];
      $loading.finish('loader');
    });
  };

  $scope.updateUOM = function(fromAddUOM){
    $loading.start('loader');
    if(fromAddUOM){
          //$scope.activity.updated_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.uom);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=updateUOM',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 0){
              SweetAlert.swal("Error In Updating Unit Of Measurement...","","error");
            }else {
              SweetAlert.swal("Unit Of Measurement Updated Successfully...","","success");
            }  
            $scope.hideAddUOMForm();
            $scope.getUOMList();
          });  
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.uom = {};
  $scope.deleteUOM = function(uom_id){
    $loading.start('loader');
    console.log(uom_id);
    $scope.uom.uom_id = uom_id;
    //$scope.uom.deleted_by = loginService.getUserName();
    var formDataJson = JSON.stringify($scope.uom);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveMasterRecords.php?operType=deleteUOM',
      data: {
        'formDataJson': formDataJson
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getUOMList();
      if(data == 1){
        SweetAlert.swal("Unit Of Measurement Deleted Successfully...","","success");
      }else {
        SweetAlert.swal("Error In Deleting Unit Of Measurement...","","error");
      }  
    });
  };

  $scope.uomNameList = [];
  $scope.getUOMNameList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getUOMNameList').success(function(uomNameList) {
      $scope.uomNameList = uomNameList;
      console.log($scope.uomNameList);
      $loading.finish('loader');
    });
  };
  /*****************  amit w code ends here  ********************/

  /*****************  sujata code starts here  ********************/

  //Storagre Location Master

$scope.storage = {};
  $scope.addStorageForm = false;
  $scope.showAddStorageForm = function() {
    $scope.addStorageForm = true;
    $scope.addStorageData = true;
    $scope.project_id = '';
    $scope.storage_id = '';
    $scope.storage_location_code = '';
    $scope.storage_location_name = '';
    $scope.storageList =[];
    $scope.storagecn={};
  };

  $scope.hideAddStorageForm = function() {
    $scope.addStorageForm = false;
    $scope.storage = {};
  };

var storageList1 = [];
  $scope.storageList1 = [];
  $scope.getStorageList = function() {
     $scope.checkReferenceIDpayment();
    $loading.start('loader');
     $scope.checkReferenceIDpayment();
    $http.get('functionFiles/getMaster.php?operType=getStorageList').success(function(storageList1) {
      $scope.storageList1 = storageList1;
 angular.forEach($scope.storageList1, function(value, key){
          if(value.active_status == 0)        
        {
          value.active_status_display = 'Active';
        }
        else if(value.active_status == 1)
        {
          value.active_status_display = 'DeActive';
        }
         });
     
      
      //console.log($scope.storageList);

      $loading.finish('loader');
    });
  };

  $scope.saveStorage = function(fromAddStorage){
    $loading.start('loader');
    if(fromAddStorage){
       var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateStorageForUpdate&&storage_id='+$scope.storage.storage_id+'&&project_name='+$scope.storage.project_name).success(function(data) {
        count = data;
        if(count != 0){
          SweetAlert.swal("Storage Already Exist...","","warning");
          $loading.finish('loader');
        }
      })
       if($scope.storageList.length == 0){
        SweetAlert.swal("Please Add Atleast One Material...","","warning");
        $loading.finish('loader');
      }else{
          $scope.storage.created_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.storage);
          var formDataJson1 = JSON.stringify($scope.storageList);
          console.log(formDataJson);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveStorage',
            data: {
              'formDataJson': formDataJson,
              'formDataJson1': formDataJson1
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 1){
              $scope.hideAddStorageForm();
              $scope.getStorageList();
              SweetAlert.swal("Storage Added Successfully...","","success");
            }else {
              SweetAlert.swal("Error In Adding Storage...","","error");
            }      
          });
          }
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };
  $scope.getStorageDetails = function(project_id,store_id){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getStorageDetails&&project_id='+project_id+'&&store_id='+store_id).success(function(data) {
      $scope.addStorageForm = true;
      $scope.addStorageData = false;
      $scope.storage = data[0];
      $scope.storageList = data;
/*$http.get('functionFiles/getMaster.php?operType=getStorageDetails&&project_id='+project_id+'&&storage_id='+storage_id).success(function(data) {

});*/
      $loading.finish('loader');
    });
  };
  $scope.updateStorage = function(fromAddStorage){
    $loading.start('loader');
    if(fromAddStorage){
      var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateStorageForUpdate&&storage_id='+$scope.storage.storage_id+'&&project_name='+$scope.storage.project_name).success(function(data) {
        count = data;
        if(count != 0){
          alert("hlo");
          SweetAlert.swal("Storage Already Exist...","","warning");
          $loading.finish('loader');
        }
          $scope.storage.updated_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.storage);
          var formDataJson1 = JSON.stringify($scope.storageList);
          console.log("formDataJson---------"+formDataJson);
          console.log("formDataJson1---------"+formDataJson1);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=updateStorage',
            data: {
              'formDataJson': formDataJson,
               'formDataJson1': formDataJson1
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 1){
              SweetAlert.swal("Error In Updating storage...","","error");
            }else {
              SweetAlert.swal("Storage Updated Successfully...","","success");
            }  
            $scope.hideAddStorageForm();
          $scope.checkReferenceIDpayment();
           $scope.getStorageList();
         });   
      });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

$scope.storage = {};
  $scope.deleteStorage = function(storage_id,active_status){
    $loading.start('loader');
    console.log(storage_id);
    $scope.storage.storage_id = storage_id;
     $scope.storage.active_status = active_status;
    $scope.storage.deleted_by = loginService.getUserName();
    var formDataJson = JSON.stringify($scope.storage);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveMasterRecords.php?operType=deleteStorage',
      data: {
        'formDataJson': formDataJson
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getStorageList();
      if(data == 1){
        SweetAlert.swal("Storage Status Changed Successfully...","","success");
      }else {
        SweetAlert.swal("Error In Deleting Storage...","","error");
      }  
    });
  };



  //store Master

  $scope.addStoreForm = false;
  $scope.showAddStoreForm = function() {
    $scope.addStoreForm = true;
    $scope.addStoreData = true;
     $scope.addStoreDataUpdate = true;
    $scope.store = {};
    $scope.store.project_id = '';
    $scope.store.store_name = '';
    $scope.store.store_location = '';
    $scope.store.store_address1 = '';
    $scope.store.address2 = '';
    $scope.store.address3 = '';
    $scope.store.state_name = '';
    $scope.store.country_name = '';
    $scope.store.city = '';
    $scope.store.supervisor_name = '';  
  };

  $scope.hideAddStoreForm = function() {
    $scope.addStoreForm = false;
    $scope.store = {};
  };


 $scope.store ={};
  $scope.saveStore = function(fromAddStore){
    $loading.start('loader');
    if(fromAddStore){
       var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateStoreForUpdate&&store_name='+$scope.store.store_name+'&&project_id='+$scope.store.project_id).success(function(data) {
        count = data;
        if(count == 0){
         $scope.store.created_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.store);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveStore',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 1){
              $scope.hideAddStoreForm();
              $scope.getStoreList();
              SweetAlert.swal("Store Added Successfully...","","success");
            }else {
              SweetAlert.swal("Error In Adding Store...","","error");
            } 
          });
        }else{
          
           SweetAlert.swal("Already Exist...","","warning");
         $loading.finish('loader');
          }
 });

    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

$scope.storeList = [];
  $scope.getStoreList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getStoreList').success(function(storeList) {
      $scope.storeList = storeList;
       angular.forEach($scope.storeList, function(value, key){
          if(value.active_status == 0)        
        {
          value.active_status_display = 'Active';
        }
        else if(value.active_status == 1)
        {
          value.active_status_display = 'DeActive';
        }
         });
      $loading.finish('loader');
    });
  };

$scope.getStoreDetails = function(store_id){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getStoreDetails&&store_id='+store_id).success(function(data) {
      $scope.addStoreForm = true;
      $scope.addStoreDataUpdate = false;
      $scope.store = data[0];
      $scope.getStateList(data[0].country_name);
      $scope.store.state_name = data[0].state_name;
      $loading.finish('loader');
    });
  };
  $scope.updateStore = function(fromAddStore){
    $loading.start('loader');
    if(fromAddStore){
     /* var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateStoreForUpdate&&store_name='+$scope.store.store_name+'&&project_id='+$scope.store.project_id).success(function(data) {
        count = data;
        if(count != 0){*/
         $scope.store.updated_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.store);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=updateStore',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 0){
              SweetAlert.swal("Error In Updating store...","","error");
            }else {
              SweetAlert.swal("Store Updated Successfully...","","success");
            }  
            $scope.hideAddStoreForm();
            $scope.getStoreList();
         });
       /*}
        else{
            SweetAlert.swal("Already Exist...","","warning");
          $loading.finish('loader');
        }
      });*/
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.store = {};
  $scope.deleteStore = function(store_id,active_status){
    $loading.start('loader');

    $scope.store.store_id = store_id;
     $scope.store.active_status = active_status;
    $scope.store.deleted_by = loginService.getUserName();
    
    var formDataJson = JSON.stringify($scope.store);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveMasterRecords.php?operType=deleteStore',
      data: {
        'formDataJson': formDataJson
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getStoreList();
      if(data == 1){
        SweetAlert.swal("Store Status Changed Successfully...","","success");
      }else {
        SweetAlert.swal("Error In Changing Store Status...","","error");
      }  
    });
  };

      //Site Master

$scope.addSiteForm = false;
  $scope.showAddSiteForm = function() {
    $scope.addSiteForm = true;
    $scope.addSiteData = true;
    $scope.site = {};
    $scope.siteList = [];
    $scope.project={};
    $scope.project.project_id = '';
    $scope.project.project_code = '';
    $scope.site.site_name = '';
    $scope.site.store_id = '';
    $scope.site.site_location = '';
    $scope.site.site_engineer_name = '';
  };

  $scope.hideAddSiteForm = function() {
    $scope.addSiteForm = false;
    $scope.site = {};
  };

  $scope.saveSite = function(fromAddSite){
    $loading.start('loader');
    if(fromAddSite){
                $scope.project.created_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.project);
          var formDataJson1 = JSON.stringify($scope.siteList);
          //console.log($scope.siteList);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveSite',
            data: {
              'formDataJson': formDataJson,
              'formDataJson1': formDataJson1
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            $scope.hideAddSiteForm();
            $scope.getSiteList();
            if(data == 1){
              SweetAlert.swal("Site Added Successfully...","","success");
            }else {
              SweetAlert.swal("Error In Adding Site...","","error");
            }      
          });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.siteList1 = [];
  $scope.getSiteList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getSite').success(function(siteList1) {
      $scope.siteList1 = siteList1;
       angular.forEach($scope.siteList1, function(value, key){
          if(value.active_status == 0)        
        {
          value.active_status_display = 'Active';
        }
        else if(value.active_status == 1)
        {
          value.active_status_display = 'DeActive';
        }
         });

       $http.get('functionFiles/getMaster.php?operType=getSiteList').success(function(siteList1) {
      $scope.siteList1 = siteList1;
        });
      $loading.finish('loader');
    });
  };

$scope.getSiteNameList = [];
  $scope.getSiteNameList= function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getSiteNameList').success(function(siteNameList) {
      $scope.siteNameList = siteNameList;
      $loading.finish('loader');
    });
  };

  $scope.getSiteDetails = function(project_id,store_id,site_engineer_name){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getSiteDetails&&project_id='+project_id+'&&store_id='+store_id+'&&site_engineer_name='+site_engineer_name).success(function(data) {
      $scope.addSiteForm = true;
      $scope.addSiteData = false;
      $scope.project = data[0];
       $scope.project.project_name=data[0].project_name;
      $scope.siteList = data;
      console.log($scope.project.project_name);
      $scope.getStoreName(data[0].project_id);
      $loading.finish('loader');
    });
  };

  $scope.updateSite = function(fromAddSite){
    $loading.start('loader');
    if(fromAddSite){
      var formDataJson = JSON.stringify($scope.project);
      var formDataJson1 = JSON.stringify($scope.siteList);

      var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateSiteForUpdate&&site_id='+$scope.site.site_id+'&&site_name='+$scope.site.site_name).success(function(data) {
        count = data;
        if(count != 0){
          SweetAlert.swal("Site Already Exist...","","warning");
          $loading.finish('loader');
        }
           $scope.project.updated_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.project);
          var formDataJson1 = JSON.stringify($scope.siteList);
          //console.log(formDataJson);
          console.log(formDataJson1);
          //var formDataJson = JSON.stringify($scope.site);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=updateSite',
            data: {
              'formDataJson': formDataJson,
              'formDataJson1': formDataJson1
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 0){
              SweetAlert.swal("Error In Updating Site...","","error");
            }else {
              SweetAlert.swal("Site Updated Successfully...","","success");
            }  
            $scope.hideAddSiteForm();
            $scope.getSiteList();
            $scope.checkReferenceIDpaymentSite();
          });
        
      });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.site = {};
  $scope.deleteSite = function(site_id,active_status){
    $loading.start('loader');
    $scope.project.site_id = site_id;
    $scope.project.active_status = active_status;
    $scope.project.deleted_by = loginService.getUserName(); 
     var formDataJson = JSON.stringify($scope.project);
     var formDataJson1 = JSON.stringify($scope.siteList);
    //var formDataJson = JSON.stringify($scope.site);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveMasterRecords.php?operType=deleteSite',
      data: {
        'formDataJson': formDataJson,
        'formDataJson1': formDataJson1
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getSiteList();
      if(data == 1){
        SweetAlert.swal("Site Status Changed Successfully...","","success");
      }else {
        SweetAlert.swal("Error In Deleting Site...","","error");
      }  
    });
  };

      //Activity Master

  $scope.addActivityForm = false;
    $scope.activity = {};
  $scope.showAddActivityForm = function() {
    $scope.addActivityForm = true;
    $scope.addActivityData = true;
    $scope.activity = {};
    $scope.activity.activity_name = '';
    $scope.activity.activity_code = '';

     var activity_code;

    $http.get('functionFiles/getMaster.php?operType=getActivityCode').success(function(data) {
      var str = data.replace(/\s+/g, '');
      
      if(str == ''){
      activity_code  = 'A00001';
      } else {
        var codeNumber = parseInt(str.slice(1)) + 1;
        var activityCodeInString = codeNumber.toString();

        if(activityCodeInString.length == 1){
        activity_code = 'A000' + activityCodeInString;
        }else if(activityCodeInString.length == 2){
          activity_code = 'A00' + activityCodeInString;
        }else if(activityCodeInString.length == 3){
          activity_code = 'A0' + activityCodeInString;
        } else {
          activity_code = 'A' + activityCodeInString;
        }
      }
     $scope.activity.activity_code = activity_code;
    });
  };
  $scope.hideAddActivityForm = function() {
    $scope.addActivityForm = false;
    $scope.activity = {};
  };

    $scope.saveActivity = function(fromAddActivity){
    $loading.start('loader');

    if(fromAddActivity){
       var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateActivity&&activity_name='+$scope.activity.activity_name).success(function(data) {
        count = data;
        if(count == 0){
          $scope.activity.created_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.activity);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveActivity',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
        //console.log(data);
            if(data == 1){
              $scope.hideAddActivityForm();
              $scope.getActivityList();
              SweetAlert.swal("Activity Added Successfully...","","success");
            }else {
              SweetAlert.swal("Error In Adding Activity...","","error");
            }      
          });
          }else{
          SweetAlert.swal("Activity Already Exist...","","warning");
          $loading.finish('loader');
          }
  });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.activityList = [];
  $scope.getActivityList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getActivityList').success(function(activityList) {
      $scope.activityList = activityList;
      angular.forEach($scope.activityList, function(value, key){
          if(value.active_status == 0)        
        {
          value.active_status_display = 'Active';
        }
        else if(value.active_status == 1)
        {
          value.active_status_display = 'DeActive';
        }
         });
      $loading.finish('loader');
    });
  };

  $scope.getActivityDetails = function(activity_id){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getActivityDetails&&activity_id='+activity_id).success(function(data) {
      $scope.addActivityForm = true;
      $scope.addActivityData = false;
      $scope.activity = data[0];
      $loading.finish('loader');
    });
  };

  $scope.updateActivity = function(fromAddActivity){
    $loading.start('loader');
    if(fromAddActivity){
      var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateActivity&&activity_name='+$scope.activity.activity_name).success(function(data) {
        count = data;
        if(count == 0){
           $scope.activity.updated_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.activity);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=updateActivity',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 0){
              SweetAlert.swal("Error In Updating activity...","","error");
            }else {
              SweetAlert.swal("Activity Updated Successfully...","","success");
            }  
            $scope.hideAddActivityForm();
            $scope.getActivityList();
          });  
         }else{ SweetAlert.swal("Activity Already Exist...","","warning");
          $loading.finish('loader');
        }
         
      });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.activity = {};
  $scope.deleteActivity = function(activity_id,active_status){
    $loading.start('loader');
    console.log(activity_id);
    console.log(active_status);
     $scope.activity.active_status = active_status;
     
    $scope.activity.activity_id = activity_id;
    $scope.activity.deleted_by = loginService.getUserName();
    var formDataJson = JSON.stringify($scope.activity);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveMasterRecords.php?operType=deleteActivity',
      data: {
        'formDataJson': formDataJson
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getActivityList();
      if(data == 1){
        SweetAlert.swal("Activity Status Changed Successfully...","","success");
      }else {
        SweetAlert.swal("Error In Deleting Activity...","","error");
      }  
    });
  };

$scope.getSiteNameList = function(store_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getSiteNameList&&store_id='+store_id).success(function(siteNameList) {
      $scope.siteNameList = siteNameList;
      $loading.finish('loader');
    });
  };


  $scope.siteLocationList = [];
  $scope.getSiteLocationList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getSiteLocationList').success(function(siteLocationList) {
      $scope.siteLocationList = siteLocationList;
      $loading.finish('loader');
    });
  };
      //Contractor Master

  $scope.addContractorForm = false;
  $scope.showAddContractorForm = function() {
    $scope.addContractorForm = true;
    $scope.addContractorData = true;
    $scope.contractor = {};
    $scope.contractor.contractor_name = '';
    $scope.contractor.contractor_address1 = '';
    $scope.contractor.address2 = '';
    $scope.contractor.address3 = '';
    $scope.contractor.state_name = '';
    $scope.contractor.country_name = '';
    $scope.contractor.city= '';
    $scope.contractor.pin_code= '';
    $scope.contractor.contact_no = '';
    $scope.contractor.contact_person = '';
    $scope.contractor.email_id = '';
    $scope.contractor.pan_details = '';
    $scope.contractor.gstin_no='';

     var contractor_number ;

    $http.get('functionFiles/getMaster.php?operType=getContractorCode').success(function(data) {
      var str = data.replace(/\s+/g, '');
      alert(data);
      if(str == ''){

      contractor_number  = 'W00001';
         alert("ankita"+contractor_number);
      } else {
        var codeNumber = parseInt(str.slice(1)) + 1;
        var contractorCodeInString = codeNumber.toString();

        if(contractorCodeInString.length == 1){
        contractor_number = 'W000' + contractorCodeInString;
        }else if(contractorCodeInString.length == 2){
          contractor_number = 'W00' + contractorCodeInString;
        }else if(contractorCodeInString.length == 3){
          contractor_number = 'W0' + contractorCodeInString;
        } else {
          contractor_number = 'W' + contractorCodeInString;
        }
      }

     $scope.contractor.contractor_number = contractor_number;
    });
  };

  $scope.hideAddContractorForm = function() {
    $scope.addContractorForm = false;
    $scope.contractor = {};
  };

  $scope.saveContractor = function(fromAddContractor){
    $loading.start('loader');
    if(fromAddContractor){
         $scope.contractor.created_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.contractor);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveContractor',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader'); 
             //console.log(data); 
            if(data == 1){
              $scope.hideAddContractorForm();
              $scope.getContractorList();
              SweetAlert.swal("Contractor Added Successfully...","","success");
            }else {
              SweetAlert.swal("Error In Adding Contractor...","","error");
            }      
          });
      }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.contractorList = [];
  $scope.getContractorList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getContractorList').success(function(contractorList) {
      $scope.contractorList = contractorList;
       angular.forEach($scope.contractorList, function(value, key){
          
        if(value.active_status == 0)        
        {
          value.active_status_display = 'Active';
        }
        else if(value.active_status == 1)
        {
          value.active_status_display = 'DeActive';
        }
      });
      $loading.finish('loader');
    });
  };

  $scope.getContractorDetails = function(contractor_id){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getContractorDetails&&contractor_id='+contractor_id).success(function(data) {
      $scope.addContractorForm = true;
      $scope.addContractorData = false;
      $scope.contractor = data[0];
      $scope.getStateList(data[0].country_name);
      $scope.contractor.state_name = data[0].state_name;
      $loading.finish('loader');
    });
  };

  $scope.updateContractor = function(fromAddContractor){
    $loading.start('loader');
    if(fromAddContractor){
      var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateContractorForUpdate&&contractor_id='+$scope.contractor.contractor_id+'&&contractor_name='+$scope.contractor.contractor_name).success(function(data) {
        count = data;
        if(count != 0){
          SweetAlert.swal("Contractor Already Exist...","","warning");
          $loading.finish('loader');
        }
          $scope.contractor.updated_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.contractor);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=updateContractor',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 0){
              SweetAlert.swal("Error In Updating contractor...","","error");
            }else {
              SweetAlert.swal("Contractor Updated Successfully...","","success");
            }  
            $scope.hideAddContractorForm();
            $scope.getContractorList();
          });
      });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.contractor = {};
  $scope.deleteContractor = function(contractor_id,active_status){
    $loading.start('loader');
     $scope.contractor.active_status = active_status;
    $scope.contractor.contractor_id = contractor_id;
    $scope.contractor.deleted_by = loginService.getUserName(); 
    var formDataJson = JSON.stringify($scope.contractor);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveMasterRecords.php?operType=deleteContractor',
      data: {
        'formDataJson': formDataJson
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getContractorList();
      if(data == 1){
        SweetAlert.swal("Contractor Status Changed Successfully...","","success");
      }else {
        SweetAlert.swal("Error In Deleting Contractor...","","error");
      }  
    });
  };

      //BOM Master

//   $scope.addBomForm = false;
//   $scope.showAddBomForm = function() {
//     $scope.addBomForm = true;
//     $scope.addBomData = true;
//     $scope.Bom = {};
//   };

// $scope.bomList = [];
//   $scope.getBomList = function() {
//     $loading.start('loader');
//     $http.get('functionFiles/getMaster.php?operType=getBomList').success(function(bomList) {
//       $scope.bomList = bomList;
//       $loading.finish('loader');
//     });
//   };

  /*****************  sujata code ends here  ********************/

  $scope.user = {};
  $scope.addUserForm = false;
  $scope.showAddUserForm = function() {
    $scope.addUserForm = true;
    $scope.addUserData = true;
    $scope.user.user_fullname = '';
    $scope.user.mobile_number = '';
    $scope.user.email_id = '';
    $scope.user.dept_id = '';
    $scope.user.user_name = '';
    $scope.user.password = '';
    $scope.user.user_role = '';
  };

  $scope.hideAddUserForm = function() {
    $scope.addUserForm = false;
    $scope.addUserData = false;
    $scope.user = {};
  };

  $scope.userList = [];
  $scope.getUserList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getUserList').success(function(userList) {
      $scope.userList = userList;
      $loading.finish('loader');
    });
  };

/*****************  Tarun code starts here  ********************/
$scope.getManagerDetails = [];
    $scope.getManagerDetails = function(manager_name) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getManagerDetails&&manager_name='+manager_name).success(function(data) {
      $scope.managerDetails = data;
      $scope.project.contact_no=data[0].mobile_number;
       $scope.project.email_id=data[0].email_id;
      $loading.finish('loader');
    });
  };

 $scope.checkReferenceIDpayment = function(refIDP) { 
      

    if(storageList1.hasOwnProperty(refIDP)) { 
       console.log('False:'+refIDP);      
       return false;
    }else{
     storageList1[refIDP] = "Double";   
       console.log('True:'+refIDP);      

     return true;
    }
  }

 $scope.checkReferenceIDInwardReport = function(refIDP) { 
      

    if(storageList1.hasOwnProperty(refIDP)) { 
       console.log('False:'+refIDP);      
       return false;
    }else{
     storageList1[refIDP] = "Double";   
       console.log('True:'+refIDP);      

     return true;
    }
  }

var siteList1=[];
 $scope.checkReferenceIDpaymentSite = function(refIDP) { 
      

    if(siteList1.hasOwnProperty(refIDP)) { 
       console.log('False:'+refIDP);      
       return false;
    }else{
     siteList1[refIDP] = "Double";   
       console.log('True:'+refIDP);      

     return true;
    }
  }

 $scope.saveRole1 = function(fromAddUser){
    $loading.start('loader');
    if(fromAddUser){
      console.log(JSON.stringify($scope.user));
      var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateRole&&user_role='+$scope.user.user_role).success(function(data) {
        count = data;
        if(count != 0){
          SweetAlert.swal("User Role Already Exist...","","warning");
          $loading.finish('loader');
        } else {
          var formDataJson = JSON.stringify($scope.user);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveRole1',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            $scope.hideAddUserForm();
            $scope.getUserRole();
            if(data != 0){
              SweetAlert.swal("User Added Successfully...","","success");          
            } else {
              SweetAlert.swal("Error In Adding User...","","error");
            }      
          });
        }
      });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };


 $scope.userRole = [];
  $scope.getUserRole = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getUserRole').success(function(userList) {
      $scope.userRole = userList;
      $loading.finish('loader');
    });
  };


  $scope.saveRole = function(fromAddUser){
    $loading.start('loader');
    if(fromAddUser){
      console.log(JSON.stringify($scope.user));
      var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateRole&&user_role='+$scope.user.user_role).success(function(data) {
        count = data;
        if(count != 0){
          SweetAlert.swal("User Role Already Exist...","","warning");
          $loading.finish('loader');
        } else {
          var formDataJson = JSON.stringify($scope.user);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveRole',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            $scope.hideAddUserForm();
            $scope.getUserRole();
            if(data != 0){
              SweetAlert.swal("User Added Successfully...","","success");          
            } else {
              SweetAlert.swal("Error In Adding User...","","error");
            }      
          });
        }
      });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };


  $scope.saveUser = function(fromAddUser){
    $loading.start('loader');
    if(fromAddUser){
      var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateUser&&user_name='+$scope.user.user_name).success(function(data) {
        count = data;
        if(count != 0){
          SweetAlert.swal("User Already Exist...","","warning");
          $loading.finish('loader');
        } else {
          var formDataJson = JSON.stringify($scope.user);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveUser',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            $scope.hideAddUserForm();
            $scope.getUserList();
            if(data != 0){
              SweetAlert.swal("User Added Successfully...","","success");          
            } else {
              SweetAlert.swal("Error In Adding User...","","error");
            }      
          });
        }
      });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  /*****************  Tarun code Ends here  ********************/

  $scope.getUserDetails = function(user_name){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getUserDetails&&user_name='+user_name).success(function(data) {
      $scope.addUserForm = true;
      $scope.addUserData = false;
      $scope.user = data;
      $scope.user.user_id = data.user_id;
      $scope.user.password = '';
      $loading.finish('loader');
    });
  };

  $scope.updateUser = function(fromAddUser){
    $loading.start('loader');
    if(fromAddUser){
      var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateUserForUpdate&&user_id='+$scope.user.user_id+'&&user_name='+$scope.user.user_name).success(function(data) {
        count = data;
        if(count != 0){
          SweetAlert.swal("User Already Exist...","","warning");
          $loading.finish('loader');
        } else {

          var formDataJson = JSON.stringify($scope.user);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=updateUser',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            $scope.hideAddUserForm();
            $scope.getUserList();
            if(data==1){
              SweetAlert.swal("User Updated Successfully...","","success");
            } else {
              SweetAlert.swal("Error In Updating User...","","error");
            }      
          });
        }
      });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.userRoleList = [];
  $scope.getUserRoleList = function() { 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getUserRoleList').success(function(userRoleList) {
      $scope.userRoleList = userRoleList;
      $loading.finish('loader');
    });
  };

  /*****************  Amit code ends here  ********************/

$scope.bom ={};
  $scope.addBomForm = false;
  $scope.showAddBomForm = function() {
    $scope.addBomForm = true;
    $scope.addBomData = true;
  
  };

  $scope.hideAddBomForm = function() {
    $scope.addBomForm = false;
    $scope.bom = {};
  };

  $scope.uploadFile = function(){  
           var form_data = new FormData();  
           angular.forEach($scope.files, function(file){  
                form_data.append('file', file);
                console.log(file);  
           });  
           $http.post('functionfiles/saveMasterRecords.php?operType=uploadFile', form_data,  
           {  
                transformRequest: angular.identity,  
                headers: {'Content-Type': undefined,'Process-Data': false}  
           }).success(function(response){  
                alert(response);  
                //$scope.select();  
           });  
      }  

  // $scope.myFile = {};
  //     $scope.uploadFile = function(){
  //       $loading.start('loader');     
  //      var formDataJson = JSON.stringify($scope.bom);
  //           var result = $.ajax({
  //         method: 'GET',
  //         url: 'functionfiles/saveMasterRecords.php?operType=createDirectory',
  //         data: {
  //           'formDataJson': formDataJson
  //           //console.log(formDataJson);

  //         }
  //       }).success(function(data, status, headers, config) {
               
  //         $loading.finish('loader');
  //         return data;
  //         console.log(data);
  //       });
  //              var file = $scope.myFile;
  //             var uploadUrl = 'functionfiles/saveMasterRecords.php?operType=uploadFile&&formDataJson=' + formDataJson + '';
  //            var msg = fileUpload.uploadFileToUrl(file, uploadUrl,formDataJson,msg); 
              
  //     };

  /*****************  Saurabh code starts here  ********************/

  $scope.AdminDashboardCount = {};
  $scope.getDashProjectCount = {};
  $scope.gettotal_sites = {};
  $scope.getgetUserCount = {};
  $scope.getAdminDashboardCount = function(){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getProjectCount').success(function(ProjectCount){
      $scope.getDashProjectCount = ProjectCount;
      console.log($scope.getDashProjectCount);
    });
    $http.get('functionFiles/getMaster.php?operType=gettotal_sites').success(function(total_sites){
      $scope.gettotal_sites = total_sites;
      console.log($scope.gettotal_sites);
    });
    $http.get('functionFiles/getMaster.php?operType=getUserCount').success(function(data){
      $scope.getgetUserCount = data;  
      $loading.finish('loader');
      console.log($scope.getgetUserCount);
     });    
  }

  
  
  /*****************  Saurabh code ends here  ********************/


  /*****************  Madhuri code starts here  ********************/
  
 $scope.managerList = [];
    $scope.getManagerList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getManagerList').success(function(data) {
      $scope.managerList = data;
      $loading.finish('loader');
    });
  };

//   $scope.DateCheck = function() {
//     if ((Date.parse($scope.project.start_date) <= Date.parse($scope.project.end_date))) {
//         alert("End date should be greater than Start date");
//     }
// }


// $scope.checkErr = function(startDate,endDate) {
//   $loading.start('loader');
//   $scope.curDate = new Date()
//     $scope.errMessage = '';
//     var curDate = new Date();

//     if(new Date(startDate) > new Date(endDate)){
//       $scope.errMessage = 'End Date should be greater than start date';
//       return false;
//     }
//     if(new Date(startDate) < curDate){
//        $scope.errMessage = 'Start date should not be before today.';
//        return false;
//     }
//     $loading.finish('loader');
// };

// $('#datetimepicker1').datetimepicker({
//   maxDate: new Date("6/8/2016"),
//   minDate: new Date("6/2/2016")
// });

  var siteNameList = [];
  $scope.siteNameList = [];
  $scope.getSiteEngineerName = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getSiteEngineerName').success(function(data) {
      $scope.siteNameList = data;
      console.log($scope.siteNameList);
      $loading.finish('loader');
    });
  };

  $scope.siteList=[];
  $scope.addSiteName = function() { //add manual materialConsumption item in table array
    var count = 0;
    var chkprtcnt = 0;
    $loading.start('loader');
      console.log($scope.site);
    if($scope.siteList!=''){
      angular.forEach($scope.siteList,function(it){
        if($scope.site.site_name == it.site_name){
          SweetAlert.swal("Site Already Exist...!","","warning");
          $scope.site={}; 
          chkprtcnt++;
        }
      });
      if(chkprtcnt==0){
        $scope.addSiteNameFinal();
        $scope.site={}; 
      }
    }else{
      $scope.addSiteNameFinal();
      $scope.site={};
    }
    $loading.finish("loader");
  };
    
  $scope.addSiteNameFinal = function() { //add manual item in table array
    
    $scope.siteList.push({
      "site_name": $scope.site.site_name,
      "site_location":$scope.site.site_location,  
      "site_engineer_name": $scope.site.site_engineer_name,
    });
  };

  $scope.deleteSiteName = function(index){ 
    $scope.siteList.splice(index,1);
  };

  $scope.getProjectCode1 = function(project_id) {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getProjectCode1&&project_id='+project_id).success(function(data) {
      $scope.project.project_code = data[0].project_code;
      $loading.finish('loader');
    });
  };

   $scope.supervisorNameList = [];
  $scope.getSupervisorList = function(store_supervisor_name) {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getSupervisorList&&store_supervisor_name='+store_supervisor_name).success(function(data) {
      $scope.supervisorNameList = data;
      $loading.finish('loader');
    });
  };

  $scope.getStoreName = function(project_id) {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getStoreName&&project_id='+project_id).success(function(storeNameList) {
      $scope.storeNameList= storeNameList;
      $loading.finish('loader');
    });
  };

  $scope.getValue = function() {
    $loading.start('loader');
     $scope.headers = Object.keys($scope.storageList1[0]);
     $scope.headers = Object.keys($scope.storageList[0]);
      $loading.finish('loader');
  };

  $scope.getValue1 = function() { 
    $loading.start('loader');
     $scope.headers = Object.keys($scope.siteList1[0]);
     $scope.headers = Object.keys($scope.siteList[0]);
      $loading.finish('loader');
  };

 $scope.getValue2 = function() {
    $loading.start('loader');
    //$http.get('functionFiles/getMaster.php?operType=getValue2&&project_code='+project_code).success(function(storeNameList) {
     $scope.headers = Object.keys($scope.projectList[0]);
      $loading.finish('loader');
      //});
  };

 $scope.getValue3 = function() {
    $loading.start('loader');
     $scope.headers = Object.keys($scope.storeList[0]);
      $loading.finish('loader');
  };

   $scope.getValue4 = function() {
    $loading.start('loader');
     $scope.headers = Object.keys($scope.materialList[0]);
      $loading.finish('loader');
  };

  $scope.getValue5 = function() {
    $loading.start('loader');
     $scope.headers = Object.keys($scope.vendorList[0]);
      $loading.finish('loader');
  };

  $scope.getValue6 = function() {
    $loading.start('loader');
     $scope.headers = Object.keys($scope.customerList[0]);
      $loading.finish('loader');
  };

  $scope.getValue7 = function() {
    $loading.start('loader');
     $scope.headers = Object.keys($scope.contractorList[0]);
      $loading.finish('loader');
  };

  $scope.getValue8 = function() {
    $loading.start('loader');
     $scope.headers = Object.keys($scope.activityList[0]);
      $loading.finish('loader');
  };

  $scope.getValue9 = function() {
    $loading.start('loader');
     $scope.headers = Object.keys($scope.activityTransactionList[0]);
      $loading.finish('loader');
  };




$scope.storagecn={};
  $scope.storageList=[];
  $scope.addStorageName = function() {
    var count = 0;
    var chkprtcnt = 0;
    $loading.start('loader');
    if($scope.storageList!=''){
      angular.forEach($scope.storageList,function(it){
        if($scope.storagecn.storage_location_code == it.storage_location_code){
          SweetAlert.swal("Already Exist...!","","warning");
          $scope.storagecn={}; 
          chkprtcnt++;
        }
      });
      if(chkprtcnt==0){
        $scope.addStorageNameFinal();
        $scope.storagecn={}; 
      }
    }else{
      $scope.addStorageNameFinal();
      $scope.storagecn={};
    }
    $loading.finish("loader");
  };
    
  $scope.addStorageNameFinal = function() {
    
    $scope.storageList.push({
      "storage_location_code":$scope.storagecn.storage_location_code,
      "storage_location_name":$scope.storagecn.storage_location_name,  
    });
  };

  $scope.deleteStorageName = function(index){ 
    $scope.storageList.splice(index,1);
  };

  /*****************  Madhuri code ends here  ********************/


 /********************************Suraj Code Starts Here**************************************/
 $scope.activityTransaction = {};
 $scope.addActivityTransactionForm = false;
  $scope.showAddActivityTransactionForm = function() {
    $scope.addActivityTransactionForm = true;
    $scope.addActivityTransactionData = true;
    $scope.activityTransaction = {};
    $scope.activityTransaction.activity_id = '';
    $scope.activityTransaction.project_id = '';
  };
  $scope.hideAddActivityTransactionForm = function() {
    $scope.addActivityTransactionForm = false;
    $scope.activityTransaction = {};
  };

    $scope.saveActivityTransaction = function(fromAddActivityTransaction){
    $loading.start('loader');
    if(fromAddActivityTransaction){
       var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateActivityTransactionForUpdate&&activity_id='+$scope.activityTransaction.activity_id+'&&project_id='+$scope.activityTransaction.project_id).success(function(data) {
        count = data;
        if(count == 0){
          $scope.activityTransaction.created_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.activityTransaction);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=saveActivityTransaction',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
        //console.log(data);
            if(data == 1){
              $scope.hideAddActivityTransactionForm();
              $scope.getActivityTransactionList();
              SweetAlert.swal("Activity Transaction Added Successfully...","","success");
            }else {
              SweetAlert.swal("Error In Adding Activity Transaction...","","error");
            }      
          });
      }else{
         SweetAlert.swal("Activity Transaction Already Exist...","","warning");
          $loading.finish('loader');
          }  
      });      
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.activityTransactionList = [];
  $scope.getActivityTransactionList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getActivityTransactionList').success(function(activityTransactionList) {
      $scope.activityTransactionList = activityTransactionList;
       angular.forEach($scope.activityTransactionList, function(value, key){
          if(value.active_status == 0)        
        {
          value.active_status_display = 'Active';
        }
        else if(value.active_status == 1)
        {
          value.active_status_display = 'DeActive';
        }
         });
     
      //console.log( $scope.activityTransactionList);
      $loading.finish('loader');
    });
  };

  $scope.getActivityTransactionDetails = function(activity_transaction_id){
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getActivityTransactionDetails&&activity_transaction_id='+activity_transaction_id).success(function(data) {
      $scope.addActivityTransactionForm = true;
      $scope.addActivityTransactionData = false;
      $scope.activityTransaction = data[0];
      $loading.finish('loader');
    });
  };

  $scope.updateActivityTransaction = function(fromAddActivityTransaction){
    $loading.start('loader');
    if(fromAddActivityTransaction){
     var count = 0;
      $http.get('functionFiles/getMaster.php?operType=checkDuplicateActivityTransactionForUpdate&&activity_id='+$scope.activityTransaction.activity_id+'&&project_id='+$scope.activityTransaction.project_id).success(function(data) {
        count = data;
        if(count == 0){
                 $scope.activityTransaction.updated_by = loginService.getUserName();
          var formDataJson = JSON.stringify($scope.activityTransaction);
          var result = $.ajax({
            method: 'POST',
            url: 'functionFiles/saveMasterRecords.php?operType=updateActivityTransaction',
            data: {
              'formDataJson': formDataJson
            }
          }).success(function(data, status, headers, config) {
            $loading.finish('loader');
            if(data == 0){
              SweetAlert.swal("Error In Updating Activity Transaction...","","error");
            }else {
              SweetAlert.swal("Activity Transaction Updated Successfully...","","success");
            }  
            $scope.hideAddActivityTransactionForm();
            $scope.getActivityTransactionList();
          }); 
          }else{
         SweetAlert.swal("Activity Transaction Already Exist...","","warning");
          $loading.finish('loader');
          }  
      });
    }else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.activityTransaction= {};
  $scope.deleteActivityTransaction= function(activity_transaction_id,active_status){
    $loading.start('loader');
    console.log(activity_transaction_id);
     $scope.activityTransaction.active_status = active_status;
    $scope.activityTransaction.activity_transaction_id = activity_transaction_id;
    $scope.activityTransaction.deleted_by = loginService.getUserName();
    var formDataJson = JSON.stringify($scope.activityTransaction);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveMasterRecords.php?operType=deleteActivityTransaction',
      data: {
        'formDataJson': formDataJson
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getActivityTransactionList();
      if(data == 1){
        SweetAlert.swal("Activity Transaction Status Changed Successfully...","","success");
      }else {
        SweetAlert.swal("Error In Deleting Activity Transaction...","","error");
      }  
    });
  };

  /********************************Suraj Code ENds Here**************************************/
  /********************************Ankita Code Starts Here**************************************/

  /********************************Ankita Code ENds Here**************************************/
  })//end Master Controllers 
app.filter('unique', function() {

  return function (arr, field) {
    var o = {}, i, l = arr.length, r = [];
    for(i=0; i<l;i+=1) {
      o[arr[i][field]] = arr[i];
    }
    for(i in o) {
      r.push(o[i]);
    }
    return r;
  };
})