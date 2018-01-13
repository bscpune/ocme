angular.module('transactionController', [])

.config(function($stateProvider) {
  $stateProvider
   /********************** Ankita Code Starts Here**************/
  .state('home.inwardGateEntry', {
    url:'/inwardGateEntry',
    templateUrl: 'modules/Transaction/inwardGateEntry.html',
    controller:'transactionCntrl'
  })

  .state('home.outwardGateEntry', {
    url:'/outwardGateEntry',
    templateUrl: 'modules/Transaction/outwardGateEntry.html',
    controller:'transactionCntrl'
  })
  .state('home.materialIssue', {
    url:'/materialIssue',
    templateUrl: 'modules/Transaction/materialIssue.html',
    controller:'transactionCntrl'
  })

  .state('home.materialReturn', {
    url:'/materialReturn',
    templateUrl: 'modules/Transaction/materialReturn.html',
    controller:'transactionCntrl'
  })
  /********************** Ankita Code ends Here**************/

  /********************** Suraj B Code Starts Here**************/
  .state('home.ImportExcel', {
    url:'/BOMMaster',
    templateUrl: 'modules/Transaction/ImportExcel.html',
    controller:'uploadjmcCTRL'
  })
 /********************** Suraj B Code Ends Here**************/
  
  /********************** Amit W Code Starts Here**************/
  .state('home.materialReceiptReport', {
    url:'/MaterialReceiptReport',
    templateUrl: 'modules/Transaction/materialReceiptReport.html',
    controller:'transactionCntrl'
  })
  .state('home.materialRejection', {
    url:'/materialRejection',
    templateUrl: 'modules/Transaction/materialRejection.html',
    controller:'transactionCntrl'
  })
  .state('home.materialTransferNote', {
    url:'/materialTransferNote',
    templateUrl: 'modules/Transaction/materialTransferNote.html',
    controller:'transactionCntrl'
  })

  /********************** Madhuri  Code Starts Here**************/
.state('home.returnByStore', {
    url:'/returnByStore',
    templateUrl: 'modules/Transaction/returnByStore.html',
    controller:'transactionCntrl'
  })

  /********************** Madhuri Code Ends Here**************/

 /********************** Amit w Code ends Here**************/
   .state('home.MaterialConsumption', {
    url:'/MaterialConsumption',
    templateUrl: 'modules/Transaction/MaterialConsumption.html',
    controller:'uploadjmcCTRL'
     })
   

 .state('home.ConsumptionApproval', {
    url:'/ConsumptionApproval',
    templateUrl: 'modules/Transaction/ConsumptionApproval.html',
    controller:'uploadjmcCTRL'
     })
   })


.controller('transactionCntrl', function($http, $state, $scope,$cookieStore, ServerService, $window, DTOptionsBuilder, $loading, loginService, $filter, $stateParams, $location, Excel, $timeout,SweetAlert,$interval) {
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

  $scope.reload=function(){
    $window.history.back();
  }



  /********************** Ankita Code Starts Here**************/

  $scope.addNewGateEntry = function(){
    $scope.addNewEntryForm = true;
    $scope.viewUpdateButton = false;
    $scope.showGenerate = false;
    $scope.viewList = false;
    $scope.showTable = false;
    $scope.savebutton =true;
    $scope.updateField = false;
    $scope.gateEntry = {};
    $scope.ReferenceMaterialList = [];
    $scope.gateEntry.inward_gate_entry_date = $filter('date')(Date.now(), 'dd-MM-yyyy');
    $scope.gateEntry.inward_time = $filter('date')(new Date(), 'HH:mm:ss');
  };

  $scope.getGateEntryCode=function(){
    $loading.start('loader');
    $scope.date = $filter('date')(Date.now(), 'ddMMyy');
    $http.get('functionFiles/getTransactionData.php?operType=getGateEntryCode').success(function(data) {
    if(data == null || data == ""){
     $scope.gateEntry.inward_gate_entry_number = '1';  
     $scope.gateEntry.inward_gate_entry_number = 'INGE'+$scope.date+'-'+$scope.gateEntry.inward_gate_entry_number;
     }else{    
    data = data.inward_gate_entry_number.substr(11);
    $scope.gateEntry.inward_gate_entry_number = data;
    $scope.gateEntry.inward_gate_entry_number = parseInt(data)+1;  
    $scope.gateEntry.inward_gate_entry_number.toString();
    $scope.gateEntry.inward_gate_entry_number = 'INGE'+$scope.date+'-'+$scope.gateEntry.inward_gate_entry_number;
     }    
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

  $scope.referenceNoLIst = [];
  $scope.getReferenceNoList = function(inventory_type_id) {// get product List for complaint close 
   
    $loading.start('loader');
    if(inventory_type_id == '2')
    {
      $http.get('functionFiles/getTransactionData.php?operType=getDeliveryNoList').success(function(referenceNoLIst) {
      $scope.referenceNoLIst = referenceNoLIst;
     // console.log($scope.referenceNoLIst);
      $loading.finish('loader');
      });
    }else{
      $http.get('functionFiles/getTransactionData.php?operType=getReferenceNoList').success(function(referenceNoLIst) {
      $scope.referenceNoLIst = referenceNoLIst;
      //console.log($scope.referenceNoLIst);
      $loading.finish('loader');
      });  
    }
  };

  $scope.getPoNoList = function(purchase_document_number) {// get product List for complaint close 
    $loading.start('loader');

 $http.get('functionFiles/getTransactionData.php?operType=getPOSupplierName&&purchase_document_number='+purchase_document_number).success(function(supplierName) {
      $scope.gateEntry.supplier_name = supplierName[0].vendor_name;
     // console.log("s"+$scope.gateEntry.supplier_name);
      $loading.finish('loader');
    });

    $http.get('functionFiles/getTransactionData.php?operType=getPOMaterialList&&purchase_document_number='+purchase_document_number).success(function(ReferenceMaterialList) {
      $scope.ReferenceMaterialList = ReferenceMaterialList;
      $loading.finish('loader');
    });
  };

  $scope.getRetrnMaterialList = function(material_return_number) {// get product List for complaint close 
    $loading.start('loader');
 $http.get('functionFiles/getTransactionData.php?operType=getReturnContractorName&&material_return_number='+material_return_number).success(function(data) {
    //  $scope.gateEntry = ReturnContractorName;
      $scope.gateEntry.project_id = data[0].project_id;
     // console.log("s"+$scope.gateEntry.supplier_name);
     $scope.getStoreList(data[0].project_id);
      $loading.finish('loader');
    });

    $http.get('functionFiles/getTransactionData.php?operType=getReturnContractorMaterialListForInward&&material_return_number='+material_return_number).success(function(referenceMaterialList) {
      $scope.ReferenceMaterialList = referenceMaterialList;
    //  alert(referenceMaterialList[0].material_name);
     // $scope.ReferenceMaterialList.material_number = referenceMaterialList[0].material_name;
    //   alert($scope.ReferenceMaterialList.material_number);
      $loading.finish('loader');
    });
  };

  $scope.getDeliveryList = function(delivery_number) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getDeliveryList&&delivery_number='+delivery_number).success(function(ReferenceMaterialList) {
      $scope.ReferenceMaterialList = ReferenceMaterialList;
      $loading.finish('loader');
    });
  };

  $scope.saveGateEntry = function(fromAddIndent){
    
    if(fromAddIndent){
      
      $scope.gateEntry.created_by = loginService.getUserName();
      //console.log($scope.ReferenceMaterialList);
      var formDataJson1 = JSON.stringify($scope.gateEntry);
      var formDataJson2 = JSON.stringify($scope.ReferenceMaterialList);
      
      var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveTransactionData.php?operType=saveGateEntry',
      data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
         }
      }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data != 0){
        $loading.finish('loader');
        $scope.gateEntry={};
        $scope.ReferenceMaterialList=[];
        SweetAlert.swal("Gate Entry Added Successfully...","","success");
        $scope.addNewEntryForm=false;
        $scope.getGateEntryList();
        
      }else {
        SweetAlert.swal("Error In Creating Gate Entry...","","error");
       }      
        }); 
        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.hideAddEntryForm = function(){
     $("#newBtn" ).show();
        $("#subBtn" ).show();
     
    $scope.addNewEntryForm = false;
    $scope.showIssueList = true;
    $scope.addNewEntryForm = false;
    $scope.viewList=true;
    $scope.viewUpdateField1 = false;
    $scope.gateEntry = {};
    $scope.ReferenceMaterialList = [];
  };

  $scope.getGateEntryList = function(reference_number) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getGateEntryList').success(function(gateEntryList) {
      $scope.gateEntryList = gateEntryList;

      angular.forEach($scope.gateEntryList, function(value, key){
        if(value.status == 0){
          value.status = 'In Progress';
        }else{
          value.status = 'In Transit';
        }
      });

      angular.forEach($scope.gateEntryList, function(value, key){
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

  $scope.getgateEntryDetailsView = function(gate_entry_id) {// get product List for complaint close 
    $loading.start('loader');
    $scope.addNewEntryForm = true;
    $scope.viewUpdateButton = false;
    $scope.updateField = true;
    $scope.savebutton =false;
    $scope.showTable=false;
     $scope.challan_quantity=true;
    $http.get('functionFiles/getTransactionData.php?operType=getgateEntryDetailsView&&gate_entry_id='+gate_entry_id).success(function(data) {
      $scope.gateEntry = data;
      if(data.inventory_type_id == 1 || data.inventory_type_id == 3){
        $scope.gateEntry.purchase_document_number = data.reference_number;
      } else if(data.inventory_type_id == 7){
         $scope.gateEntry.material_return_number = data.reference_number;
      }
      else {
        $scope.gateEntry.delivery_number = data.reference_number;
      }
      $scope.getReferenceNoList(data.inventory_type_id);
      $scope.getStoreList(data.project_id);
      $http.get('functionFiles/getTransactionData.php?operType=getGateEntryMaterials&&gate_entry_id='+gate_entry_id).success(function(list) {
      $scope.ReferenceMaterialList = list;
      $loading.finish('loader');
    });
    });
  };

 $scope.getgateEntryDetailsView1 = function(gate_entry_id) {// get product List for complaint close 
    $loading.start('loader');
    $scope.addNewEntryForm = true;
    $scope.viewUpdateButton = true;
    $scope.savebutton =false;
    $scope.showTable=false;
    $http.get('functionFiles/getTransactionData.php?operType=getgateEntryDetailsView&&gate_entry_id='+gate_entry_id).success(function(data) {
      $scope.gateEntry = data;
      if(data.inventory_type_id == 1 || data.inventory_type_id == 3){
        $scope.gateEntry.purchase_document_number = data.reference_number;
      }else {
        $scope.gateEntry.delivery_number = data.reference_number;
      }
      $scope.gateEntry.outward_time = $filter('date')(new Date(), 'HH:mm:ss');
      $scope.gateEntry.time_out = $filter('date')(new Date(), 'HH:mm:ss');
      $scope.getReferenceNoList(data.inventory_type_id);
      $scope.getStoreList(data.project_id);
      $http.get('functionFiles/getTransactionData.php?operType=getGateEntryMaterials&&gate_entry_id='+gate_entry_id).success(function(list) {
      $scope.ReferenceMaterialList = list;
      $loading.finish('loader');
    });
    });
  };

  $scope.updateOutwardTime = function(fromAddIndent){
    
    if(fromAddIndent){
      $scope.gateEntry.time_out = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss');
      var formDataJson1 = JSON.stringify($scope.gateEntry);
      var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveTransactionData.php?operType=updateOutwardTime',
      data: {
          'formDataJson1': formDataJson1
         }
      }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      //console.log(data);
      if(data != 0){
        $loading.finish('loader');
        $scope.gateEntry={};
        $scope.ReferenceMaterialList=[];
        SweetAlert.swal("Outward Time updated Successfully...","","success");
        $scope.addNewEntryForm=false;
        $scope.getGateEntryList();
        
      }else {
        SweetAlert.swal("Error In Updating Time...","","error");
       }      
        }); 
        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

   $scope.addNewMaterialIssue = function(){
    $scope.addNewEntryForm = true;
    $scope.viewUpdateButton = false;
    $scope.showGenerate = false;
    $scope.viewList = false;
    $scope.showTable = false;
    $scope.savebutton =true;
    $scope.updateField = false;
    $scope.showIssueList = true;
  $scope.issue = {};
  $scope.IndentMaterialList = [];
  $scope.getMaterialIssueNumber();
  $scope.issue.material_issue_date='';
  $scope.issue.reference_no='';
  $scope.issue.inventory_type='';
  $scope.issue.activity_name='';
  $scope.issue.site_location='';
  $scope.issue.contractor_id='';
  $scope.issue.issued_to_name='';
  $scope.issue.remark='';
  $scope.issue.loc_no='';
  };

  $scope.returnMaterial = function(){
    
    $scope.showIssueList = true;
    $scope.addNewEntryForm = false;
    $scope.viewReturnList = false;
    $scope.consumption.loc_no='';
     $scope.viewList = true;
  };

  

  $scope.hideIssueList = function(){
    $scope.showIssueList = false;
    $scope.viewReturnList = true;
  };

$scope.hideConsumpForm = function(){
    $scope.viewUpdateField1 = false;
    $scope.addNewEntryForm = false;
    $scope.viewList = true;
  };

    $scope.hideForm = function(){
    $scope.viewUpdateButton = false;
    $scope.viewReturnList = true;
    $scope.addNewEntryForm = false;
  };

  // $scope.getIssueData = function(contractor_inventory_id) {// get product List for complaint close 
  //   $loading.start('loader');
  //   $http.get('functionFiles/getTransactionData.php?operType=getIssueData&&contractor_inventory_id='+contractor_inventory_id).success(function(ReferenceMaterialList) {
  //     $scope.ReferenceMaterialList = ReferenceMaterialList;
  //     $loading.finish('loader');
  //   });
  // };

  $scope.gateEntry={};
  $scope.ReferenceMaterialList={};
  $scope.getIssueMaterialListoutward = function(contractor_inventory_id){
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getIssueMaterialList&&contractor_inventory_id='+contractor_inventory_id).success(function(list) {
      $scope.ReferenceMaterialList= list;
      
    $http.get('functionFiles/getTransactionData.php?operType=getIssueData&&contractor_inventory_id='+contractor_inventory_id).success(function(data) {
      $scope.gateEntry.inventory_type=data.inventory_type;
      $loading.finish('loader');
    });
  });
  }

  // $scope.getIssueMaterialList = function(contractor_inventory_id) {// get product List for complaint close 
  //   $loading.start('loader');
  //   $http.get('functionFiles/getTransactionData.php?operType=getIssueMaterialList&&contractor_inventory_id='+contractor_inventory_id).success(function(issueMaterialList) {
  //     $scope.gateEntry = issueMaterialList;
  //     $http.get('functionFiles/getTransactionData.php?operType=getIssueData&&contractor_inventory_id='+contractor_inventory_id).success(function(ReferenceMaterialList) {
  //     $scope.ReferenceMaterialList = ReferenceMaterialList;
  //     console.log($scope.gateEntry);
  //     $loading.finish('loader');
  //   });
  //   });
  // };

  $scope.getIndentMaterialList = function(reference_number) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getIndentMaterialList&&reference_number='+reference_number).success(function(issueMaterialList) {
      $scope.ReferenceMaterialList = issueMaterialList;

      $loading.finish('loader');
    });
  };

$scope.getSiteNameList = function(project_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getSiteNameList&&project_id='+project_id).success(function(siteNameList) {
      $scope.siteNameList = siteNameList;
    //console.log($scope.siteNameList);
      $loading.finish('loader');
    });
  };

  $scope.getProjectNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getProjectNameList').success(function(projectNameList) {
      $scope.projectNameList = projectNameList;
      $loading.finish('loader');
    });
  };

  $scope.getCustomerNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getCustomerNameList').success(function(customerNameList) {
      $scope.customerNameList = customerNameList;
      $loading.finish('loader');
    });
  };

  $scope.getStoreNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getStoreNameList').success(function(storeNameList) {
      $scope.storeNameList = storeNameList;
      $loading.finish('loader');
    });
  };


  $scope.getStoreName = function(s_project_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getStoreName&&s_project_id='+s_project_id).success(function(storeName) {
      $scope.storeName = storeName;
    //console.log($scope.storeName);
      $loading.finish('loader');
    });
  };

  $scope.getStoreName1 = function(d_project_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getStoreName1&&d_project_id='+d_project_id).success(function(storeName) {
      $scope.storeName1 = storeName;
    //console.log($scope.storeName1);
      $loading.finish('loader');
    });
  };

  $scope.getContractorName = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getContractorName').success(function(contractorName) {
      $scope.contractorName = contractorName;
    //console.log($scope.contractorName);
      $loading.finish('loader');
    });
  };

$scope.getStoreList = function(project_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getStoreList&&project_id='+project_id).success(function(storeNameList) {
      $scope.storeNameList = storeNameList;
      $loading.finish('loader');
    });
  };

$scope.getStoreListConsumption = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getStoreListConsumption').success(function(storeNameList) {
      $scope.storeNameList = storeNameList;
      $loading.finish('loader');
    });
  };


  $scope.getContractorName1 = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getContractorName1').success(function(contractorName) {
      $scope.contractorName1 = contractorName;
    console.log($scope.contractorName1);
      $loading.finish('loader');
    });
  };

  $scope.activityNameList = [];
  $scope.getActivityNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getMaster.php?operType=getActivityNameList').success(function(activityNameList) {
      $scope.activityNameList = activityNameList;
      $loading.finish('loader');
    });
  };
  /******************************Outward Gate Entry*****************************/

  $scope.addNewOutwardGateEntry = function(){
    $scope.addNewEntryForm = true;
    $scope.viewUpdateButton = false;
    $scope.showTable=true;
    $scope.viewList = false;
    $scope.showfield=true;
    $scope.generatePDF=false;
    $scope.updateField = false;
    $scope.showIssueList = true;
    $scope.gateEntry = {};
    $scope.ReferenceMaterialList = [];
    $scope.gateEntry.outward_date = $filter('date')(Date.now(), 'dd-MM-yyyy');
    $scope.gateEntry.inward_time = $filter('date')(new Date(), 'HH:mm:ss');
  };

  $scope.getOutwardGECode=function(){
    $loading.start('loader');
    $scope.date = $filter('date')(Date.now(), 'ddMMyy');
    $http.get('functionFiles/getTransactionData.php?operType=getOutwardGECode').success(function(data) {
    if(data == null || data == ""){
     $scope.gateEntry.outward_ge_code = '1';  
     $scope.gateEntry.outward_ge_code = 'OUTGE'+$scope.date+'-'+$scope.gateEntry.outward_ge_code;
     }else{    
    data = data.outward_ge_code.substr(8);
    $scope.gateEntry.outward_ge_code = data;
    $scope.gateEntry.outward_ge_code = parseInt(data)+1;  
    $scope.gateEntry.outward_ge_code.toString();
    $scope.gateEntry.outward_ge_code = 'OUTGE'+$scope.date+'-'+$scope.gateEntry.outward_ge_code;
     }  
    $loading.finish('loader');
    });
  };


  $scope.saveOutwardGateEntry = function(saveEntry){
      if(true){
      $scope.gateEntry.created_by = loginService.getUserName();
      //console.log($scope.ReferenceMaterialList);
      var formDataJson1 = JSON.stringify($scope.gateEntry);
      //var formDataJson2 = JSON.stringify($scope.ReferenceMaterialList);
      
      var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveTransactionData.php?operType=saveOutwardGateEntry',
      data: {
          'formDataJson1': formDataJson1,
          //'formDataJson2': formDataJson2
         }
      }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data != 0){
        $loading.finish('loader');
        $scope.gateEntry={};
        $scope.ReferenceMaterialList=[];
        SweetAlert.swal("Gate Entry Added Successfully...","","success");
        $scope.addNewEntryForm=false;
        $scope.getOutwardGateEntryList();
        
      }else {
        SweetAlert.swal("Error In Creating Gate Entry...","","error");
       }      
        });
      } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }  
  };

  $scope.getOutwardGateEntryList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getOutwardGateEntryList').success(function(gateEntryList) {
      $scope.gateEntryList = gateEntryList;

      angular.forEach($scope.gateEntryList, function(value, key){
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
    

    angular.forEach($scope.gateEntryList, function(value, key){
        if(value.inventory_type == 1)        
        {
          value.inventory_type = 'Emco Stock';
        }
        else if (value.inventory_type == 2)
        {
          value.inventory_type = 'OSM Stock';
        }
        else{
          value.inventory_type = 'T & P Stock';
        }
      });
      $loading.finish('loader');
    });
  };

  $scope.getOutwardGateEntryDetails = function(outward_gate_entry_id) {// get product List for complaint close 
    $loading.start('loader');
    $scope.addNewEntryForm = true;
    $scope.viewUpdateButton = true;
    $scope.showfield=false;
    $scope.showTable=false;
    $http.get('functionFiles/getTransactionData.php?operType=getOutwardGateEntryDetails&&outward_gate_entry_id='+outward_gate_entry_id).success(function(data) {
      $scope.gateEntry = data;
      $scope.getStoreList(data.project_id);
      $scope.gateEntry.outward_time = $filter('date')(new Date(), 'HH:mm:ss');
      // $http.get('functionFiles/getTransactionData.php?operType=getGateEntryMaterials&&gate_entry_id='+gate_entry_id).success(function(data) {
      // $scope.ReferenceMaterialList = data;
      $loading.finish('loader');
    });
  
  };

  $scope.updateOutwardEntry = function(fromAddIndent){
    
    if(fromAddIndent){
      $scope.gateEntry.outward_time = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss');
     // console.log($scope.gateEntry);
      var formDataJson1 = JSON.stringify($scope.gateEntry);
      var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveTransactionData.php?operType=updateOutwardEntry',
      data: {
          'formDataJson1': formDataJson1
         }
      }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data != 0){
        $loading.finish('loader');
        $scope.gateEntry={};
        $scope.ReferenceMaterialList=[];
        SweetAlert.swal("Outward Time updated Successfully...","","success");
        $scope.addNewEntryForm=false;
        $scope.getOutwardGateEntryList();
        
      }else {
        SweetAlert.swal("Error In Updating Time...","","error");
       }      
        }); 
        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.referenceNoLIst = [];
  $scope.getReferenceList = function(outward_type) {// get product List for complaint close 
    $loading.start('loader');
    if(outward_type == '2')
    {
      
      $http.get('functionFiles/getTransactionData.php?operType=getReferenceList').success(function(referenceNoLIst) {
      $scope.referenceNoLIst = referenceNoLIst;
       console.log($scope.referenceNoLIst);
      $loading.finish('loader');
      });
    }

    if(outward_type == '1')
      {
         
      $http.get('functionFiles/getTransactionData.php?operType=getIssueCodeList').success(function(referenceNoLIst) {
      $scope.referenceNoLIst = referenceNoLIst;
      //console.log($scope.referenceNoLIst);
      $loading.finish('loader');
      });
    }
  };
  /******************************************************************************/

  $scope.getContractorList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getContractorList').success(function(contractorList) {
      $scope.contractorList = contractorList;
    });
     $http.get('functionFiles/getTransactionData.php?operType=getIndentListContractor').success(function(indentListContractor) {
      $scope.indentListContractor = indentListContractor;
    });
           $loading.finish('loader');
  };
  $scope.StockMaterial= [];
  $scope.getIssueMaterialList = function(indent_code){
   // console.log(JSON.Stringify($scope.indentListContractor));
    $scope.indent_code = indent_code;
    angular.forEach($scope.indentListContractor,function(it){
        if($scope.indent_code == it.indent_code){
          $http.get('functionFiles/getIndent.php?operType=getMaterialStockListPROSTO&&project_id='+it.project_id).success(function(materialstockList) {
      $scope.materialstockList = materialstockList;
      //console.log($scope.materialstockList[0].material_number);     
          
        });

        }
      });

    
  };
  $scope.getIndentMaterialListIssue = function(indent_code) {// get product List for complaint close 
    $scope.getIssueMaterialList(indent_code);
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getIndentMaterialListIssue&&indent_code='+indent_code).success(function(data) {
    $scope.issue.activity_name = data.activity_name;
    $scope.issue.site_location = data.site_location;
    $scope.issue.project_id = data.project_id;
    $scope.issue.store_id = data.store_id;
    $scope.issue.contractor_id = data.contractor_id;

    });
    $http.get('functionFiles/getTransactionData.php?operType=getIndentMaterialListIssue1&&indent_code='+indent_code).success(function(IndentMaterialList) {
    $scope.IndentMaterialList = IndentMaterialList;
     console.log($scope.IndentMaterialList);
     angular.forEach($scope.IndentMaterialList,function(item){
        angular.forEach($scope.materialstockList,function(it){
          if(item.material_code == it.material_number){
            item.remaining_qty = it.remaining_qty;
            
          }
        });
      });
     });

  /*  $http.get('functionFiles/getTransactionData.php?operType=getStoreInventoryMaterialStock&&indent_code='+indent_code).success(function(StockMaterial) {
  $scope.StockMaterial= StockMaterial;
   console.log(JSON.Stringify($scope.StockMaterial));
});*/
$loading.finish('loader');
  };//

  $scope.issue={};
   $scope.getMaterialIssueNumber=function(){
    $loading.start('loader');
    $scope.date = $filter('date')(Date.now(), 'ddMMyy');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialIssueNumber').success(function(data) {
    if(data == null || data == ""){
     $scope.issue.material_issue_number = '1';  
     $scope.issue.material_issue_number = 'MI'+$scope.date+'-'+$scope.issue.material_issue_number;
     }else{    
    data = data.material_issue_number.substr(9);
    $scope.issue.material_issue_number = data;
    $scope.issue.material_issue_number = parseInt(data)+1;  
    $scope.issue.material_issue_number.toString();
    $scope.issue.material_issue_number = 'MI'+$scope.date+'-'+$scope.issue.material_issue_number;
     }  
     /*console.log($scope.issue.material_issue_code);*/
    $loading.finish('loader');
    });
  };

  $scope.saveMaterialIssue = function(fromAddIndent){
    if(fromAddIndent){
      $scope.issue.created_by = loginService.getUserName();
      var formDataJson1 = JSON.stringify($scope.issue);
      console.log(formDataJson1);
      var formDataJson2 = JSON.stringify($scope.IndentMaterialList);
      var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveTransactionData.php?operType=saveMaterialIssue',
      data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
         }
      }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data == 1){
        $loading.finish('loader');
        $scope.issue={};
        $scope.IndentMaterialList=[];
        SweetAlert.swal("Material Issue Added Successfully...","","success");
        $scope.addNewEntryForm=false;
        $scope.getMaterialIssueList();
        
      }else {
        SweetAlert.swal("Error In Creating Material Issue...","","error");
       }      
        }); 
        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };


  $scope.checkQuantity = function(remaining_qty,issued_qty,indent_remaining_quantity,index) {
    

    if(parseInt(remaining_qty) < parseInt(indent_remaining_quantity)){
    if(parseInt(remaining_qty) < parseInt(issued_qty))
    {
      SweetAlert.swal("Please Enter Valid Quantity...","","warning");
     $scope.IndentMaterialList[index].issued_qty= $scope.IndentMaterialList[index].remaining_qty; 
   
    }}else if(parseInt(indent_remaining_quantity) < parseInt(issued_qty)){
SweetAlert.swal("Please Enter Valid Quantity...","","warning");
     $scope.IndentMaterialList[index].issued_qty= 0; 
   
    }
  };

$scope.checkQuantitymaterialissue = function(indent_remaining_qty,issued_qty,index) {
    
    if(parseInt(indent_remaining_qty) < parseInt(issued_qty))
    {
      SweetAlert.swal("Please Enter Valid Quantity...","","warning");
     $scope.IndentMaterialList[index].issued_qty= $scope.IndentMaterialList[index].indent_remaining_qty; 
    }
  };

  // $scope.calculate1 = function(approved_total_qty,issued_qty) {
  //   angular.forEach($scope.materialList, function(){
  //   $scope.approved_total_qty=parseInt(approved_total_qty)-parseInt(issued_qty);
  //   console.log($scope.approved_total_qty);
  // });
  // };

  $scope.getMaterialIssueList = function(indent_code) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialIssueList').success(function(issueList) {
      $scope.issueList = issueList;
      $loading.finish('loader');
    });
  };

  $scope.getMaterialIssueDetails = function(contractor_inventory_id) {// get product List for complaint close 
    $loading.start('loader');
     $("#newBtn" ).hide();
     $("#subBtn" ).hide();
    $scope.addNewEntryForm = true;
    $scope.showIssueList = false;
    $scope.viewUpdateButton = false;
     $scope.viewReturnList = false;
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialIssueDetails&&contractor_inventory_id='+contractor_inventory_id).success(function(issue) {
      $scope.issue = issue;
      $scope.getStoreList(issue.project_id);
      //console.log($scope.contractor_inventory_id);
      $http.get('functionFiles/getTransactionData.php?operType=getIssueListView&&contractor_inventory_id='+contractor_inventory_id).success(function(data) {
      $scope.IndentMaterialList = data;
     // alert( $scope.IndentMaterialList.material_code);
      angular.forEach($scope.IndentMaterialList,function(item){
        angular.forEach($scope.materialstockList,function(it){
          if(item.material_code == it.material_number){
            item.remaining_qty = it.remaining_qty;
            alert(item.remaining_qty);
          }
        });
      });
      //console.log($scope.contractor_inventory_id);
      $loading.finish('loader');
    });
    });
  };

  $scope.getReturnDetails = function(material_return_code) {// get product List for complaint close 
    $loading.start('loader');
    $scope.addNewEntryForm = true;
    $scope.showIssueList = false;
    $scope.addStoreForm = true;
    $scope.viewUpdateButton = true;
    $scope.viewUpdateField1=true;
    $scope.returnSubmit = true;
   /* $scope.updateField = true;
     $scope.hideThis = true;*/
     $scope.viewReturnList = false;
    $http.get('functionFiles/getTransactionData.php?operType=getReturnDetails&&material_return_code='+material_return_code).success(function(issue) {
      $scope.consumptionheader = issue;
      $http.get('functionFiles/getTransactionData.php?operType=getReturnListView&&material_return_code='+material_return_code).success(function(data) {
      $scope.consumptionheaderList = data;
      $scope.addNewEntryForm=false;
      $loading.finish('loader');
    });
    });
  };

  $scope.saveMaterialReurn = function(fromAddIndent){    
    if(fromAddIndent){
      
      var formDataJson1 = JSON.stringify($scope.consumptionheader);
      var formDataJson2 = JSON.stringify($scope.consumptionheaderList);
      console.log($scope.consumptionheader);
      console.log($scope.consumptionheaderList);
      var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveTransactionData.php?operType=saveMaterialReurn',
      data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
         }
      }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data != 0){
        $loading.finish('loader');
        $scope.issue={};
        $scope.IndentMaterialList=[];
        SweetAlert.swal("Material Returned Successfully...","","success");
        $scope.viewUpdateButton = false;
        $scope.viewReturnList = true;
        $scope.addNewEntryForm = false;
        $scope.getMaterialreturnList();
        $scope.viewUpdateField1=false;
        
      }else {
        SweetAlert.swal("Error In Creating Gate Entry...","","error");
       }      
        }); 
        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.getMaterialReturnCode=function(){
    $loading.start('loader');
    $scope.date = $filter('date')(Date.now(), 'ddMMyy');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialReturnCode').success(function(data) {

    if(data == null || data == ""){
      //alert(data.material_return_code);
     $scope.consumptionheader.material_return_code = '1';  
     $scope.consumptionheader.material_return_code = 'RET'+$scope.date+'-'+$scope.consumptionheader.material_return_code;
     }else{    
    data = data.material_return_code.substr(10);
    $scope.consumptionheader.material_return_code = data;
    $scope.consumptionheader.material_return_code = parseInt(data)+1;  
    $scope.consumptionheader.material_return_code.toString();
    $scope.consumptionheader.material_return_code = 'RET'+$scope.date+'-'+$scope.consumptionheader.material_return_code;
     }  
     console.log($scope.consumptionheader.material_return_code);
    $loading.finish('loader');
    });
  };

  $scope.getMaterialreturnList = function() {// get product List for complaint close 
    $loading.start('loader');
    $scope.viewReturnList=true;
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialreturnList').success(function(issueList) {
      $scope.returnList = issueList;
      $scope.hideThis = true;
      $scope.viewList = false;
      $loading.finish('loader');
    });
  };

  $scope.getMaterialCodeList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialCodeList').success(function(materialCodeList) {
      $scope.materialCodeList = materialCodeList;
      $loading.finish('loader');
    });
  };

  $scope.indentMaterial={};
   $scope.getMaterialCodeDetails = function(material_code){
    $loading.start('loader');
    console.log();
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialCodeDetails&&material_code='+material_code).success(function(data) {
    //  console.log(data.unit_of_measurment);      
      if(data == '' || data == null){
        $scope.indentMaterial.unit_of_measurment = '';
        $scope.indentMaterial.material_name = '';
        $scope.indentMaterial.material_id = '';
        $scope.indentMaterial.material_description = '';
        $loading.finish('loader');
      } else {
        $scope.indentMaterial.unit_of_measurment = data.unit_of_measurment;
        $scope.indentMaterial.material_name = data.material_name;
        $scope.indentMaterial.material_id = data.material_id;
        $scope.indentMaterial.material_code = data.material_code;
        $scope.indentMaterial.material_description = data.material_description;
        $scope.indentMaterial.unit_price = data.unit_price;
        $loading.finish('loader');
      }
    });
  };

  $scope.addIndentMaterial = function() { //add indent item in table array
    var count = 0;
    var chkprtcnt = 0;
    $loading.start('loader');
      
    if($scope.indentMaterialList!=''){
      angular.forEach($scope.indentMaterialList,function(it){
        if($scope.indentMaterial.material_code == it.material_code){
          SweetAlert.swal("Material Code Already Exist...!","","warning");
          $scope.indentMaterial={}; 
          chkprtcnt++;
        }
      });
      if(chkprtcnt==0){
        $scope.addIndentMaterialFinal();
        $scope.indentMaterial={}; 
      }
    }else{
      $scope.addIndentMaterialFinal();
      $scope.indentMaterial={};
    }
    $loading.finish("loader");
  };
    
  $scope.addIndentMaterialFinal = function() { //add inndent item in table array
    
    $scope.ReferenceMaterialList.push({
      "material_id": $scope.indentMaterial.material_id,
      "material_name": $scope.indentMaterial.material_name,
      "material_code": $scope.indentMaterial.material_code,
      "material_description":$scope.indentMaterial.material_description,
      "net_value": $scope.indentMaterial.net_value,
      "billing_quantity": $scope.indentMaterial.billing_quantity,
       "unit_of_measurment": $scope.indentMaterial.unit_of_measurment,
        "quantity": $scope.indentMaterial.indent_material_qty,
      "challan_quantity" :$scope.indentMaterial.challan_quantity,
       "material_number": $scope.indentMaterial.material_number,
    });
  };

  $scope.deleteIndentMaterial = function(index){ 
    $scope.indentMaterialList.splice(index,1);
  };

  /********************** Ankita Code Ends Here**************/


  /********************** Suraj Code Starts Here**************/
   $scope.excelList = [];
   $scope.getExcelList = function() {
     $scope.table = false;
    $loading.start('loader');
    $http.get('functionFiles/uploadExcel.php?operType=getExcelList').success(function(excelList) {
      $scope.excelList = excelList;
       angular.forEach($scope.excelList, function(it) {       
        });
      $loading.finish('loader');
    });
  };

   $scope.SelectedFileForUpload = null;
 
    $scope.UploadFile = function (files) {
        $scope.$apply(function () { //I have used $scope.$apply because I will call this function from File input type control which is not supported 2 way binding
            $scope.Message = "";
            $scope.SelectedFileForUpload = files[0];
        })
    }
 
    //Parse Excel Data 
    $scope.excel={};
    $scope.ParseExcelDataAndSave = function (fromExceldataImport) {
      if(fromExceldataImport){
        var file = $scope.SelectedFileForUpload;
        var excel=$scope.excel;
        console.log("9999  "+$scope.excel);
        $scope.table = true;
        if (file ) {
            
            var reader = new FileReader();
            reader.onload = function (e) {

                var data = e.target.result;
                //XLSX from js-xlsx library , which I will add in page view page
                var workbook = XLSX.read(data, { type: 'binary' });
                var sheetName = workbook.SheetNames[0];
                var excelData = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);          if (excelData.length > 0) {
                    //Save data 
                    $scope.SaveImportExcelData(excelData,excel);
                }
                else {
                    $scope.Message = "No data found";
                }
            }

            reader.onerror = function (ex) {
                console.log(ex);
            }
 
            reader.readAsBinaryString(file);
        }
        } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
    }
 
    // Save excel data to our database
    $scope.SaveImportExcelData = function (excelData,excel) {

        var formDataJson1 = JSON.stringify(excel);
        var formDataJson2 = JSON.stringify(excelData);

        console.log(formDataJson1+"----"+formDataJson2);
        $http({
            method: "POST",
            url: "functionfiles/uploadExcel.php?operType=saveExcel",
            data:{
                'formDataJson1': formDataJson1,
                'formDataJson2': formDataJson2},
             dataType: 'json',
            headers: {
                'Content-Type' : 'application/json'
            }
        }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data != 0){
        console.log("data"+data);
        $loading.finish('loader');
       SweetAlert.swal("Excel Data Successfully...","","success");
        $scope.getExcelList();
        $("#newBtn" ).show();
         $scope.excel= [];
          $scope.excelData = [];
          $scope.SelectedFileForUpload = null;
      }else {
        SweetAlert.swal("Error In Uploading Excel Data...","","error");
       }      
        });
    }
  $scope.hideTable = function(){
    $scope.table = true
    $scope.SelectedFileForUpload = null;
    $("#newBtn" ).hide();
      };
       $scope.showTable = function(){
    $scope.table = false
    $scope.SelectedFileForUpload = null;
    $("#newBtn" ).show();
      };

   //material Consumption
    //  $scope.consumption= [];
  $scope.saveExceldataConsumption = function (fromExceldataConsumption) {
    if(fromExceldataConsumption){
        var file = $scope.SelectedFileForUpload;
       var consumption=$scope.consumption;
        alert( JSON.stringify($scope.consumption));
        $scope.table = true;
        if (file ) {
                    var reader = new FileReader();
            reader.onload = function (e) {

                var data = e.target.result;
                //XLSX from js-xlsx library , which I will add in page view page
                var workbook = XLSX.read(data, { type: 'binary' });
                var sheetName = workbook.SheetNames[0];
                var excelData = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);          if (excelData.length > 0) {
                    //Save data 
                    $scope.SaveData(excelData,consumption);
                }
                else {
                    $scope.Message = "No data found";
                }
            }

            reader.onerror = function (ex) {
                console.log(ex);
            }
 
            reader.readAsBinaryString(file);
        }
       } else{
            SweetAlert.swal("Please Enter a Vald Data...","","error");
          }  
    }
 
    // Save excel data to our database
    $scope.SaveData = function (excelData,consumption) {

        var formDataJson1 = JSON.stringify(consumption);
        var formDataJson2 = JSON.stringify(excelData);
        $http({
            method: "POST",
            url: "functionfiles/uploadExcel.php?operType=saveExcelMaterialConsumption",
            data:{
                'formDataJson1': formDataJson1,
                'formDataJson2': formDataJson2},
             dataType: 'json',
            headers: {
                'Content-Type' : 'application/json'
            }
        }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data != 0){
        $loading.finish('loader');
       SweetAlert.swal("Excel Data Successfully...","","success");
        $scope.getMaterialConsumptionList();
         $scope.excel= [];
         $scope.consumption={};
          $scope.excelData = [];
          $scope.SelectedFileForUpload = null;          
    $scope.addNewEntryForm = false;
    $("#newBtn" ).show();
      }else {
        SweetAlert.swal("Error In Uploading Excel Data...","","error");
       }      
        });
    }

    $scope.consumption={};
   $scope.getMaterialConsumptionCode=function(){
    $loading.start('loader');
    $("#newBtn" ).hide();
    $scope.date = $filter('date')(Date.now(), 'ddMMyy');
    $http.get('functionFiles/uploadExcel.php?operType=getMaterialConsumtionCode').success(function(data) {
    if(data == null || data == ""){
     $scope.consumption.material_consumption_code = '1';  
     $scope.consumption.material_consumption_code = 'MC'+$scope.date+'-'+$scope.consumption.material_consumption_code;
     }else{    
    data = data.material_consumption_code.substr(9);
    $scope.consumption.material_consumption_code = data;
    $scope.consumption.material_consumption_code = parseInt(data)+1;  
    $scope.consumption.material_consumption_code.toString();
    $scope.consumption.material_consumption_code = 'MC'+$scope.date+'-'+$scope.consumption.material_consumption_code;
     }  
    $loading.finish('loader');
    });
  };

   $scope.getMaterialConsumptionList = function() {// get product List for complaint close 
    $loading.start('loader');
    /*$("#updateField" ).show();*/
    $scope.viewList = true;
  $http.get('functionFiles/uploadExcel.php?operType=getMaterialConsumptionList').success(function(consumptionList) {
      $scope.consumptionList = consumptionList;

$http.get('functionFiles/uploadExcel.php?operType=getMaterialConsumptionListforReturn').success(function(consumptionList1) {
      $scope.consumptionList1 = consumptionList1;

      $loading.finish('loader');
    });
});
  };

  $scope.getMaterialConsumptionDetails = function(material_consumption_code) {// get product List for complaint close 
    $loading.start('loader');
    $scope.date = $filter('date')(Date.now(), 'ddMMyy');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialReturnCode').success(function(data) {

    if(data == null || data == ""){
      //alert(data.material_return_code);
     $scope.consumptionheader.material_return_code = '1';  
     $scope.consumptionheader.material_return_code = 'RET'+$scope.date+'-'+$scope.consumptionheader.material_return_code;
     }else{    
    data = data.material_return_code.substr(10);
    $scope.consumptionheader.material_return_code = data;
    $scope.consumptionheader.material_return_code = parseInt(data)+1;  
    $scope.consumptionheader.material_return_code.toString();
    $scope.consumptionheader.material_return_code = 'RET'+$scope.date+'-'+$scope.consumptionheader.material_return_code;
     }  
     console.log($scope.consumptionheader.material_return_code);
    $loading.finish('loader');
    });


    $scope.addNewEntryForm = false;
    $scope.viewUpdateField1 = true;
    $scope.viewList = false;
   $scope.materialReturn = true;
   $scope.showIssueList = false;
     $("#newBtn" ).hide();
    $http.get('functionFiles/uploadExcel.php?operType=getMaterialConsumptionDetails&&material_consumption_code='+material_consumption_code).success(function(consumptionheader) {
    $scope.consumptionheader = consumptionheader;
    $http.get('functionFiles/uploadExcel.php?operType=getConsumptionListView&&material_consumption_code='+material_consumption_code).success(function(consumptionheaderList) {
    $scope.consumptionheaderList = consumptionheaderList;

    $loading.finish('loader');
    });
    });
  };
//MANUAL UPLOAD MATERIAL CONSUMPTION


//Gate Matrial Name List
$scope.getMaterialNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialNameList').success(function(materialNameList) {
      $scope.materialNameList = materialNameList;
      $loading.finish('loader');
    });
  };
$scope.manualMaterialList=[];
  $scope.addManualMaterialConsumption = function() { //add manual materialConsumption item in table array
    var count = 0;
    var chkprtcnt = 0;
    $loading.start('loader');
      console.log($scope.manual);
    if($scope.manualMaterialList!=''){
      angular.forEach($scope.manualMaterialList,function(it){
        if($scope.manual.material_name == it.material_name){
          SweetAlert.swal("Material Already Exist...!","","warning");
          $scope.manual={}; 
          chkprtcnt++;
        }
      });
      if(chkprtcnt==0){
        $scope.addManualMaterialFinal();
        $scope.manual={}; 
      }
    }else{
      $scope.addManualMaterialFinal();
      $scope.manual={};
    }
    $loading.finish("loader");
  };
    
  $scope.addManualMaterialFinal = function() { //add manual item in table array
    
    $scope.manualMaterialList.push({
      "material_name": $scope.manual.material_name,
      "issued_qty": $scope.manual.issued_qty,
      "consumed_qty":$scope.manual.consumed_qty,
      "remaining_qty": $scope.manual.remaining_qty,    
    });
  };

  $scope.deleteManualMaterial = function(index){ 
    $scope.manualMaterialList.splice(index,1);
  };
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
 
/*app.service('fileUpload', ['$http', function ($http,SweetAlert) {
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
*/


 $scope.myFile = {};

$scope.manual={};
$scope.consumption={};
$scope.manualMaterialList=[];
$scope.savemanualdataConsumption = function (manualUpload) {
if(manualUpload){
        var formDataJson1 = JSON.stringify($scope.consumption);
       var formDataJson2 = JSON.stringify($scope.indentListContractor);
        console.log(formDataJson1+"---"+formDataJson2);
        $http({
            method: "POST",
            url: "functionfiles/uploadExcel.php?operType=saveExcelMaterialConsumption",
            data:{
                'formDataJson1': formDataJson1,
                'formDataJson2': formDataJson2},
             dataType: 'json',
            headers: {
                'Content-Type' : 'application/json'
            }
        }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data != 0){
        console.log("data"+data);
        $loading.finish('loader');
       SweetAlert.swal("Excel Data Successfully...","","success");
        $scope.getMaterialConsumptionList();
         $scope.consumtion= {};
          $scope.manual = [];       
    $scope.addNewEntryForm = false;
    $("#newBtn" ).show();
      }else {
        SweetAlert.swal("Error In Uploading Excel Data...","","error");
       }      
        });
      }else{
       SweetAlert.swal("Please Enter a Vald Data...","","error");
      }

             var file = $scope.myFile;
             console.log("ffffff"+JSON.stringify(file));
              var uploadUrl = 'functionfiles/uploadExcel.php?operType=uploadFile&&formDataJson1=' + formDataJson1 + '';
             var msg = fileUpload.uploadFileToUrl(file, uploadUrl,formDataJson1,msg);

    }

    $scope.hideConsumptionForm = function(){
    $scope.viewUpdateField1 = false;
    $scope.addNewEntryForm = false;
    $scope.viewList = true;
    $("#newBtn" ).show();
  };
  /********************** Suraj Code Ends Here**************/

  /********************** Amit W Code Starts Here**************/
  
  $scope.addMRRForm = false;
  $scope.showAddMRRForm = function() {
    $scope.addMRRForm = true;
    $scope.addMRRData = true;
    $scope.showNo = true;
    $scope.supplier = false;
    $scope.showNumber = true;
    $scope.showpdf = false;
      $scope.mrr = {};
  $scope.mrrList1 = [];
  $scope.materialList = [];
  $scope.mrr.location_of_despatch='';
   $scope.mrr.remark='';
    //$scope.mrr.mrr_date = $filter('date')(new Date(), 'dd-MM-yyyy');
  };

  $scope.hideAddMRRForm = function() {
    $scope.addMRRForm = false;
    $scope.addMRRData = true;
    // $scope.mrr ={};
    // $scope.mrrList ={};
    //$scope.mrrList = [];
    //$scope.getMRRList();
  };

  $scope.mrrList = [];
  $scope.mrrList1 = [];
  $scope.materialList = [];
  $scope.getMRRList = function() {// get product List for complaint close 
    $loading.start('loader');
  /*  angular.forEach($scope.materialList, function(id){
    $scope.materialList.rejected_quantity = parseFloat(id.quantity)- parseFloat(id.accepted_quantity);
    /*$scope.materialList./
  // console(materialList.rejected_quantity);
  });*/
    
    $http.get('functionFiles/getTransactionData.php?operType=getMRRList').success(function(mrrList) {
      $scope.mrrList = mrrList;
      $loading.finish('loader');
      
        if(mrrList.inventory_type_id === 1)        
        {
          mrrList.inventory_type_id = 'Emco Stock';
        }
        else if (mrrList.inventory_type_id === 2)
        {
          mrrList.inventory_type_id = 'OSM Stock';
        }
        else{
          mrrList.inventory_type_id = 'T & P Stock';
        }
      });
    

    $http.get('functionFiles/getTransactionData.php?operType=getMaterialRejectList').success(function(mrrList) {
      $scope.mrrList1 = mrrList;
      $loading.finish('loader');
    });
  };

  $scope.gateEntryCodeList = [];
  $scope.getGateEntryCodeList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getGateEntryCodeList').success(function(gateEntryCodeList) {
      $scope.gateEntryCodeList = gateEntryCodeList;
      //console.log($scope.gateEntry.gate_entry_id);
      $loading.finish('loader');
    });
  };

  $scope.mrr={};
  $scope.materialList={};
  $scope.getGateEntryData = function(gate_entry_id){

    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getGateEntryData&&gate_entry_id='+gate_entry_id).success(function(data) {
      $scope.mrr= data[0];
      //$scope.mrr.inventory_type_id =data[0].inventory_type_name;
console.log($scope.mrr.inventory_type_id);
if($scope.mrr.inventory_type_id =='Material Return'){
  $scope.MaterialReturn = true;
}else{
  $scope.all = true;
}
      console.log($scope.mrr);
      
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialDescriptionList&&gate_entry_id='+gate_entry_id).success(function(data) {
      $scope.materialList= data;
      console.log($scope.materialList);
      $scope.mrr.mrr_date = $filter('date')(new Date(), 'dd-MM-yyyy');
      //$scope.mrr.rejection_date = $filter('date')(new Date(), 'dd-MM-yyyy');
console.log("p"+$scope.mrr.project_id);
console.log("s"+$scope.mrr.store_id);

      
      $http.get('functionFiles/getTransactionData.php?operType=getStorageLocationList&&project_id='+$scope.mrr.project_id+ '&&store_id='+$scope.mrr.store_id).success(function(data) {
      $scope.storageLocationList= data;
      console.log("list"+$scope.storageLocationList);
    });
    
    var mrrCode;
    $http.get('functionFiles/getTransactionData.php?operType=getMRRCode').success(function(data) {
      var str = data.replace(/\s+/g, '');
      if(str == ''){
        mrrCode = 'MRR0001';
      } else {
        //console.log($scope.mrrCodeInString);
        var codeNumber = parseInt(str.slice(3)) + 1;
        var mrrCodeInString = codeNumber.toString();

        if(mrrCodeInString.length == 1){
          mrrCode = 'MRR000' + mrrCodeInString;
        }else if(mrrCodeInString.length == 2){
          mrrCode = 'MRR00' + mrrCodeInString;
        }else if(mrrCodeInString.length == 3){
          mrrCode = 'MRR0' + mrrCodeInString;
        } else {
          mrrCode = 'MRR' + mrrCodeInString;
        }
      }
      $scope.mrr.mrr_code = mrrCode;
    });
   /* if($scope.mrr.inventory_type_id === 1)        
        {
          $scope.mrr.inventory_type_id = 'Emco Stock';
        }
        else if ($scope.mrr.inventory_type_id === 2)
        {
          $scope.mrr.inventory_type_id = 'OSM Stock';
        }
        else{
          $scope.mrr.inventory_type_id = 'T & P Stock';
        }*/
      //console.log($scope.mrr);
      //console.log($scope.materialList);
      $loading.finish('loader');
    });
  });
  }

  //$scope.materialList={};
  // $scope.calculate = function(index,quantity,accepted_quantity) {
  //   angular.forEach($scope.materialList, function(){
  //   $scope.rejected_quantity=parseInt(quantity)-parseInt(accepted_quantity);
  //   console.log($scope.rejected_quantity);
  // });
  // };
  // $scope.calculate =function(){
  //   angular.forEach($scope.materialList, function(id){
  //   $scope.mrr.rejected_quantity = parseFloat(id.quantity)- parseFloat(id.accepted_quantity);
  // console.log($scope.materialList.rejected_quantity);
  // });
  // }
  // $scope.materialList=[];
  // $scope.getMaterialDescriptionList =function(gate_entry_id){
  //   $loading.start('loader');
  //     $http.get('functionFiles/getTransactionData.php?operType=getMaterialDescriptionList&&gate_entry_id='+gate_entry_id).success(function(data) {
  //     $scope.materialList= data[0];
  //     console.log($scope.materialList);
  //   $loading.finish('loader');
  // });
  // }
  //$scope.accepted_qauntity=[];
  $scope.checkAccQuantity = function(index,po_balance_qty,accepted_quantity) {
    
    if(parseInt(po_balance_qty) < parseInt(accepted_quantity))
    {
      SweetAlert.swal("Please Enter Valid Quantity...","","warning");
      $scope.materialList[index].accepted_quantity= $scope.materialList[index].po_balance_qty;

    }
      // alert($scope.materialList[index].quantity);
      // alert($scope.materialList[index].accepted_quantity);
       /*$scope.rejected_quantity1=parseFloat($scope.materialList[index].quantity) -parseFloat($scope.materialList[index].accepted_quantity);
   $scope.materialList[index].rejected_quantity= $scope.rejected_quantity1;*/
   //console.log("ssss"+$scope.materialList[index].rejected_quantity);
   //console.log("rrrr"+$scope.rejected_quantity1);
  };

   $scope.mrrQtyCheck = function(accepted_quantity,challan_qty,index) {
     if(parseInt(challan_qty) < parseInt(accepted_quantity))
    {
      SweetAlert.swal("Please Enter Valid Quantity...","","warning");
      $scope.materialList[index].accepted_quantity='';
      $scope.materialList[index].rejected_quantity='';
    }
    $scope.materialList[index].rejected_quantity= parseFloat($scope.materialList[index].challan_qty) - parseFloat($scope.materialList[index].accepted_quantity);

      // alert($scope.materialList[index].quantity);
      // alert($scope.materialList[index].accepted_quantity);
     //  $scope.rejected_quantity1=parseFloat($scope.materialList[index].quantity) -parseFloat($scope.materialList[index].accepted_quantity);
 //  $scope.materialList[index].rejected_quantity= $scope.rejected_quantity1;
   //console.log("ssss"+$scope.materialList[index].rejected_quantity);
   //console.log("rrrr"+$scope.rejected_quantity1);
  };

  $scope.mrr={};
  $scope.materialList={};
  $scope.saveMRR = function(savedata){
   $scope.mrr.total_quantity= 0;
   $scope.mrr.total_rejected_quantity=0; 
    if(savedata){
      $scope.mrr.created_by = loginService.getUserName();
      //console.log($scope.materialList);
        angular.forEach($scope.materialList, function(id){
        $scope.mrr.total_quantity = parseFloat($scope.mrr.total_quantity) + parseFloat(id.challan_qty);
        $scope.mrr.total_rejected_quantity = parseFloat($scope.mrr.total_rejected_quantity) + parseFloat(id.rejected_quantity); 
           // if (value.total_quantity > 0) {
           // value.quantity = value.total_quantity;
           // }
         //console.log($scope.mrr.total_quantity);
         });
      var formDataJson1 = JSON.stringify($scope.mrr);
      var formDataJson2 = JSON.stringify($scope.materialList);
      console.log(formDataJson1);
      console.log(formDataJson2);
      var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveTransactionData.php?operType=saveMRR',
      data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
         }
      }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data !== 0){
        $loading.finish('loader');
        $scope.hideAddMRRForm();
        $scope.mrr={};
        $scope.materialList={};
        $scope.getMRRList();
        SweetAlert.swal("MRR Added Successfully...","","success");
        
      }else {
        SweetAlert.swal("Error In Creating MRR...","","error");
       }      
        }); 
        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.getMrrDetails = function(mrr_id) {// get product List for complaint close 
    $loading.start('loader');
    $scope.addMRRForm = true;
    $scope.addMRRData = false;
    $scope.showNo=false;
    $scope.showNumber = false;
    $scope.supplier=true;
    $scope.showpdf = true;
    //$scope.mrr.rejection_date = $filter('date')(new Date(), 'dd-MM-yyyy');
    $http.get('functionFiles/getTransactionData.php?operType=getMrrDetails&&mrr_id='+mrr_id).success(function(mrrdata) {
      $scope.mrr = mrrdata;
      $scope.getGateEntryCodeList(mrrdata.gate_entry_code);
      console.log(mrrdata.gate_entry_code);
        // if($scope.mrr.inventory_type_id == 1)        
        // {
        //   $scope.mrr.inventory_type_id = 'Emco Stock';
        // }
        // else if ($scope.mrr.inventory_type_id == 2)
        // {
        //   $scope.mrr.inventory_type_id = 'OSM Stock';
        // }
        // else{
        //   $scope.mrr.inventory_type_id = 'T & P Stock';
        // }

      $http.get('functionFiles/getTransactionData.php?operType=getMrrMaterials&&mrr_id='+mrr_id).success(function(data) {
      $scope.materialList = data;
     // $scope.materialList.storage_location_code=data[0].storage_location_code;
     // console.log("rr"+data[0].storage_location_code);
$scope.slc=true;
      $loading.finish('loader');
    });
    });
  };

  $scope.getMrDetails = function(mrr_id) {// get product List for complaint close 
    $loading.start('loader');
    
    $scope.addMRRForm = true;
    $scope.addMRRData = true;
    var mrCode;
    $http.get('functionFiles/getTransactionData.php?operType=getMRCode').success(function(data) {
      var str = data.replace(/\s+/g, '');
      if(str == ''){
        mrCode = 'REJ0001';
      } else {
        //console.log($scope.mrrCodeInString);
        var codeNumber = parseInt(str.slice(3)) + 1;
        var mrCodeInString = codeNumber.toString();

        if(mrCodeInString.length == 1){
          mrCode = 'REJ000' + mrCodeInString;
        }else if(mrCodeInString.length == 2){
          mrCode = 'REJ00' + mrCodeInString;
        }else if(mrCodeInString.length == 3){
          mrCode = 'REJ0' + mrCodeInString;
        } else {
          mrCode = 'REJ' + mrCodeInString;
        }
      }
      $scope.mrr.material_rejection_code = mrCode;
    
    $scope.supplier=true;
    
    $scope.mrr.inventory_type_id={};
    $http.get('functionFiles/getTransactionData.php?operType=getMrrDetails&&mrr_id='+mrr_id).success(function(mrrdata) {
      $scope.mrr = mrrdata;
      $scope.mrr.material_rejection_code = mrCode;
      
        // if($scope.mrr.inventory_type_id == 1)        
        // {
        //   $scope.mrr.inventory_type_id = 'Emco Stock';
        // }
        // else if ($scope.mrr.inventory_type_id == 2)
        // {
        //   $scope.mrr.inventory_type_id = 'OSM Stock';
        // }
        // else{
        //   $scope.mrr.inventory_type_id = 'T & P Stock';
        // }
      

      $http.get('functionFiles/getTransactionData.php?operType=getMrMaterials&&mrr_id='+mrr_id).success(function(data) {
        $scope.materialList = data;
        $scope.mrr.rejection_date = $filter('date')(new Date(), 'dd-MM-yyyy');
      $loading.finish('loader');
    });
    });
    });
  };

  $scope.getMrDetails1 = function(mrr_id) {// get product List for complaint close 
    $loading.start('loader');
    
    $scope.addMRRForm = true;
    $scope.addMRRData = false;
    $scope.supplier=true;
    
    $scope.mrr.inventory_type_id={};
    $http.get('functionFiles/getTransactionData.php?operType=getMrrDetails&&mrr_id='+mrr_id).success(function(mrrdata) {
      $scope.mrr = mrrdata;
      // if($scope.mrr.inventory_type_id == 1)        
      //   {
      //     $scope.mrr.inventory_type_id = 'Emco Stock';
      //   }
      //   else if ($scope.mrr.inventory_type_id == 2)
      //   {
      //     $scope.mrr.inventory_type_id = 'OSM Stock';
      //   }
      //   else{
      //     $scope.mrr.inventory_type_id = 'T & P Stock';
      //   }

      $http.get('functionFiles/getTransactionData.php?operType=getMrMaterials&&mrr_id='+mrr_id).success(function(data) {
      $scope.materialList = data;
      $scope.mrr.rejection_date = $filter('date')(new Date(), 'dd-MM-yyyy');
    //console.log($scope.mrr.rejection_date);
      $loading.finish('loader');
    });
    });
  };


  $scope.mrr={};
  $scope.materialList={};
  $scope.saveMaterialRejection = function(savedata){
   $scope.mrr.total_quantity= 0; 
    if(savedata){
      $scope.mrr.created_by = loginService.getUserName();
      //$scope.mrr.updated_by =loginService.getUserName();
      //console.log($scope.materialList);
        angular.forEach($scope.materialList, function(id){
        $scope.mrr.total_quantity = parseFloat($scope.mrr.total_quantity) + parseFloat(id.quantity); 
           // if (value.total_quantity > 0) {
           // value.quantity = value.total_quantity;
           // }
         //console.log($scope.mrr.total_quantity);
         });
      var formDataJson1 = JSON.stringify($scope.mrr);
      var formDataJson2 = JSON.stringify($scope.materialList);
      //console.log(formDataJson1);
      //console.log(formDataJson2);
      var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveTransactionData.php?operType=saveMaterialRejection',
      data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
         }
      }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data == 1){
        $loading.finish('loader');
        $scope.hideAddMRRForm();
        // $scope.mrr={};
        $scope.addMRRData=false;
        $scope.getMRRList();
        SweetAlert.swal("Material Rejection Added Successfully...","","success");
        
      }else {
        SweetAlert.swal("Error In Creating Material Rejection...","","error");
       }      
        }); 
        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.mtn={};
  $scope.addMTNForm = false;
  $scope.showAddMTNForm = function() {
    $scope.addMTNForm = true;
    $scope.addMTNData = true;
    $scope.addMaterialData = true;
    $scope.materialNumberList = [];
    $scope.materialTransfer = {};
    $scope.mtn.transfer_date = $filter('date')(new Date(), 'dd-MM-yyyy');
    var mtnCode;
    $http.get('functionFiles/getTransactionData.php?operType=getMTNCode').success(function(data) {
      var str = data.replace(/\s+/g, '');
      if(str == ''){
        mtnCode = 'MTN0001';
      } else {
        //console.log($scope.mrrCodeInString);
        var codeNumber = parseInt(str.slice(3)) + 1;
        var mtnCodeInString = codeNumber.toString();

        if(mtnCodeInString.length == 1){
          mtnCode = 'MTN000' + mtnCodeInString;
        }else if(mtnCodeInString.length == 2){
          mtnCode = 'MTN00' + mtnCodeInString;
        }else if(mtnCodeInString.length == 3){
          mtnCode = 'MTN0' + mtnCodeInString;
        } else {
          mtnCode = 'MTN' + mtnCodeInString;
        }
      }
      $scope.mtn.transfer_code = mtnCode;
    });
  };

  $scope.hideAddMTNForm = function() {
    $scope.addMTNForm = false;
    $scope.addMTNData = true;
    //$scope.mrrList = [];
    //$scope.getMRRList();
  };

  $scope.mtn={};
  $scope.storeData={};
  $scope.saveMaterialTransferNote = function(id){
    //alert($scope.contractor_inventory_id+"---"+$scope.store_inventory_id);
   //alert($scope.mtn.s_contractor_id);
  // if($scope.mtn.s_contractor_id == null || $scope.mtn.s_contractor_id == undefined || $scope.mtn.s_contractor_id == ''){
  //       alert("vghg1");
  //       $scope.mtn.s_contractor_id=0;
  //       $scope.mtn.d_contractor_id=0;
  //     }else{
  //       $scope.mtn.s_contractor_id=$scope.mtn.s_contractor_id;
  //       $scope.mtn.d_contractor_id=$scope.mtn.d_contractor_id;
  //     }
  //     alert($scope.mtn.d_contractor_id+"dd"+$scope.mtn.s_contractor_id);
    
    if($scope.mtn.transfer_type=='Contractor To Contractor'){ 
    //alert('ttttt'); 
  $scope.mtn.s_contractor_id=$scope.mtn.s_contractor_id;
   $scope.mtn.d_contractor_id=$scope.mtn.d_contractor_id;
   
   }else{
    $scope.mtn.s_contractor_id='';
   $scope.mtn.d_contractor_id='';
   }

    if(true){
      
      $scope.mtn.created_by = loginService.getUserName();
      var formDataJson1 = JSON.stringify($scope.mtn);
      var formDataJson2 = JSON.stringify($scope.storeData);
      //console.log(formDataJson1);
     //console.log(formDataJson2);
      var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveTransactionData.php?operType=saveMaterialTransferNote',
      data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
         }
      }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data == 1){
        $loading.finish('loader');
        $scope.hideAddMTNForm();
        $scope.mtn={};
        $scope.storeData={};
        $scope.getMTNList();
        SweetAlert.swal("MTN Added Successfully...","","success");
        
      }else {
        SweetAlert.swal("Error In Creating MTN...","","error");
       }      
        }); 
        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.mtnSourceList = [];
  //$scope.mtnDestList = [];
  $scope.getMTNList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getMTNSList').success(function(mtnSourceList) {
      $scope.mtnSourceList = mtnSourceList;
    // $http.get('functionFiles/getTransactionData.php?operType=getMTNDList').success(function(mtnDestList) {
    //   $scope.mtnDestList = mtnDestList;
      //console.log($scope.mtnList);
      $loading.finish('loader');
    });
  
  };

  

  // $scope.materialTransfer = {};
  // //$scope.indentMaterialList = [];

  // $scope.getMaterialTransferDetails = function(material_number){
  //   $loading.start('loader');
  //   console.log("hey");
  //   $http.get('functionFiles/getTransactionData.php?operType=getMaterialTransferDetails&&material_number='+material_number).success(function(data) {
  //     if(data == '' || data == null){
  //       //$scope.materialTransfer.material_number = "";
  //       $scope.materialTransfer.material_description = '';
  //       $scope.materialTransfer.issued_quantity = '';
  //       $scope.materialTransfer.transfer_quantity = '';
  //       $scope.materialTransfer.remark = '';
  //       $loading.finish('loader');
  //     } else {
  //       $scope.materialTransfer.material_number = data.material_number;
  //       $scope.materialTransfer.material_description = data.material_description;
  //       $scope.materialTransfer.issued_quantity = data.issued_quantity;
  //       $scope.materialTransfer.transfer_quantity = data.transfer_quantity;
  //       $scope.materialTransfer.remark = data.remark;
  //       $loading.finish('loader');
  //     }
  //   });
  // };


  
  $scope.storeData={};
  $scope.getMaterialData = function(s_store_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getStoreData&&s_store_id='+s_store_id).success(function(storeName) {
      $scope.storeData = storeName;
      console.log($scope.storeData);
      $loading.finish('loader');
    });
  };

  //$scope.contractorData={};
  $scope.getTransferData = function(s_store_id,s_contractor_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getContractorData&&s_store_id='+s_store_id+ '&&s_contractor_id='+s_contractor_id).success(function(contractorName) {
      $scope.storeData = contractorName;
      console.log($scope.storeData);
      $loading.finish('loader');
    });
  };

  $scope.mtn={};
  $scope.storeData={};
  $scope.getMtnDetails = function(mtn_id) {// get product List for complaint close 
    $loading.start('loader');
    $scope.addMTNForm = true;
    $scope.addMTNData = false;
    $scope.supplier=true;
    $http.get('functionFiles/getTransactionData.php?operType=getMtnDetails&&mtn_id='+mtn_id).success(function(mtndata) {
      $scope.mtn = mtndata;

     //  console.log("jjjj"+JSON.stringify(mtndata));
     //  $scope.mtn.s_project_id=mtndata.s_project_name;
     // console.log("jjjjjjj",$scope.mtn.s_project_name);
      //$scope.mrr.gate_entry_id=mrrdata.gate_entry_code;
      //console.log("jjjjjj"+$scope.mrr.gate_entry_id);
//console.log($scope.gateEntry.time_out);
      if($scope.mtn.transfer_type=='Contractor To Contractor'){
        $http.get('functionFiles/getTransactionData.php?operType=getMtnContractorMaterials&&mtn_id='+mtn_id).success(function(cdata) {
      $scope.storeData = cdata;
      
    });
    }else {
      $http.get('functionFiles/getTransactionData.php?operType=getMtnStoreMaterials&&mtn_id='+mtn_id).success(function(sdata) {
      $scope.storeData = sdata;
    });
    }
      $loading.finish('loader');
    });
    
  };
  /********************** Amit W Code Ends Here**************/

  /************** Sujata Code Starts Here************/

   /*------------------------------Tarun------------*/

 $scope.checkBalanceQty = function(quantity,challan_quantity,mrr_balance_quantity,index) {
    
    if(mrr_balance_quantity == '' || mrr_balance_quantity == null || mrr_balance_quantity== undefined ){
    if(parseInt(quantity) < parseInt(challan_quantity))
    {
      SweetAlert.swal("Challan qty must be less than PO qty...","","warning");
 $scope.ReferenceMaterialList[index].challan_quantity =  $scope.ReferenceMaterialList[index].quantity;
    }
  // $scope.ReferenceMaterialList[index].balance_quantity  = parseFloat($scope.ReferenceMaterialList[index].quantity) - parseFloat($scope.ReferenceMaterialList[index].challan_quantity);
  }else{

    if(parseInt(mrr_balance_quantity) < parseInt(challan_quantity))
    {
      SweetAlert.swal("Challan qty must be less than PO balance qty...","","warning");
 $scope.ReferenceMaterialList[index].challan_quantity =  $scope.ReferenceMaterialList[index].mrr_balance_quantity;
    }
  }
 

  };

  $scope.getMaterialIssueNumberList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialIssueNumberList').success(function(MaterialIssueList) {
      $scope.MaterialIssueList = MaterialIssueList;
      console.log("kkkk"+$scope.MaterialIssueList);
    });
  };

$scope.getActivityNameListforConsumption = function(site_id) {// get product List for complaint close 
    $loading.start('loader');
    angular.forEach($scope.siteNameList,function(it){
      if(it.site_id == site_id){
        $scope.consumption.location = it.site_location;
      }
    })
    console.log( $scope.consumption.location+ "jj"+ it.site_location)

    $http.get('functionFiles/getTransactionData.php?operType=getActivityNameListforConsumption&&site_id='+site_id).success(function(activityNameList) {
      $scope.activityNameList = activityNameList;
    console.log($scope.activityNameList);
      $loading.finish('loader');
    });
  };

$scope.getContractorNameforConsumption = function(activity_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getContractorNameforConsumption&&activity_id='+activity_id).success(function(contractorNameList) {
      $scope.contractorNameList = contractorNameList;
    console.log($scope.contractorNameList);
      $loading.finish('loader');
    });
  };


   $scope.getSiteNameforConsumption = function(project_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getSiteNameforConsumption&&project_id='+project_id).success(function(siteNameList) {
      $scope.siteNameList = siteNameList;
      console.log("kkkk"+$scope.siteNameList);
    });
  };

$scope.getDetailsofMaterialIssue = function(material_issue_number) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getDetailsofMaterialIssue&&material_issue_number='+material_issue_number).success(function(DetailsMaterialIssueList) {
      $scope.DetailsMaterialIssueList = DetailsMaterialIssueList;
      $loading.finish('loader');
    });
  };

  
 


   $scope.getMaterialListContractorforConsumption = function(contractor_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialListContractorforConsumption&&contractor_id='+contractor_id).success(function(indentListContractor) {
      $scope.indentListContractor = indentListContractor;
      $scope.materialtable=true;
      $scope.excelsubmitbtn=false;
      console.log( "jjjjj"+$scope.indentListContractor)
      $loading.finish('loader');
    });
  };
 

 $scope.referenceNoLIst = [];
  $scope.getReturnReferenceList = function(return_type) {// get product List for complaint close 
    $loading.start('loader');
    if(return_type == '2')
    {
      
      $http.get('functionFiles/getTransactionData.php?operType=getReturncontractorReferenceList').success(function(returnreferenceNoLIst) {
      $scope.returnreferenceNoLIst = returnreferenceNoLIst;
       console.log($scope.referenceNoLIst);
      $loading.finish('loader');
      });
    }

    if(return_type == '1')
      {
         
      $http.get('functionFiles/getTransactionData.php?operType=getReturnstoreReferenceList').success(function(returnreferenceNoLIst) {
      $scope.returnreferenceNoLIst = returnreferenceNoLIst;
      //console.log($scope.referenceNoLIst);
      $loading.finish('loader');
      });
    }
  };

   $scope.gateEntry={};
  $scope.getReturnMaterialList={};
  $scope.getReturnMaterialList = function(return_no){
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getReturnMaterialList&&return_no='+return_no).success(function(list) {
      $scope.ReferenceMaterialList= list;
      console.log("outward"+JSON.stringify($scope.ReferenceMaterialList));
      
   /* $http.get('functionFiles/getTransactionData.php?operType=getIssueData&&contractor_inventory_id='+contractor_inventory_id).success(function(data) {
      $scope.gateEntry.inventory_type=data.inventory_type;
      $loading.finish('loader');
    });*/
  });
  }
 /*------------------------------Tarun------------*/

 /************** Madhuri Code Starts Here************/
 
  $scope.returnReasonList={};
  $scope.getReasonReturn = function(reason_return) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getReasonReturn&&reason_return='+reason_return).success(function(data) {
      $scope.returnReasonList = data;
      $loading.finish('loader');
    });
  };

    $scope.getDetailsforStore = function(mrr_id) {// get product List for complaint close 
    $loading.start('loader');
    $scope.showIssueList =false;
    $scope.addStoreForm = true;
    $scope.addStoreData = false;
    //$scope.supplier=true;
    //$scope.mrr.rejection_date = $filter('date')(new Date(), 'dd-MM-yyyy');
    $http.get('functionFiles/getTransactionData.php?operType=getMrrDetails&&mrr_id='+mrr_id).success(function(mrrdata) {
      $scope.mrr = mrrdata;
      //console.log(mrrdata);
      //$scope.mrr.gate_entry_id=mrrdata.gate_entry_code;
      //console.log("jjjjjj"+$scope.mrr.gate_entry_id);
//console.log($scope.gateEntry.time_out);
      $http.get('functionFiles/getTransactionData.php?operType=getMrrMaterials&&mrr_id='+mrr_id).success(function(data) {
      $scope.materialList = data;
      $loading.finish('loader');
    });
    });
  };

  $scope.addStoreForm = false;
  $scope.showReturnBYStore = function() {
    $scope.addStoreForm = true;
    $scope.addStoreData = true;


    //$scope.mrr.mrr_date = $filter('date')(new Date(), 'dd-MM-yyyy');
  };

  $scope.hideReturnBYStore = function() {
  $scope.addStoreForm = false;
  $scope.showIssueList =true;
  $scope.addStoreForm = false;
    $scope.addStoreData = true;

  /*  
   $scope.addNewEntryForm = false;
    $scope.showIssueList = true;
    $scope.addNewEntryForm = false;
    $scope.viewList=true;
    $scope.viewUpdateField1 = false;
    $scope.gateEntry = {};
    $scope.ReferenceMaterialList = [];*/
  };

$scope.materialList1 = [];
$scope.getReturnDetailsForStore = function(mrr_id) {
    $loading.start('loader');
    $scope.addStoreForm = true;
    $scope.showIssueList = false;
    $scope.viewUpdateButton1 = true;
    $scope.showIssueList =false;
    $scope.addStoreForm = true;
    $scope.addStoreData = false;
    //$scope.updateField = true;
     $scope.viewReturnList = false;
    $http.get('functionFiles/getTransactionData.php?operType=getReturnDetailsForStore&&mrr_id='+mrr_id).success(function(data) {
      $scope.mrr = data;
      $http.get('functionFiles/getTransactionData.php?operType=getReturnListForStore&&mrr_id='+mrr_id).success(function(list) {
        $scope.materialList1 = list;
        $loading.finish('loader');
      });
    });
  };

   $scope.hideForm1 = function(){
    $scope.viewUpdateButton1 = false;
    $scope.viewReturnList = true;
    $scope.addStoreForm = false;
  };

  $scope.returnMaterialStore = function(){ 
    $scope.showIssueList = true;
    $scope.addStoreForm = false;
    $scope.viewReturnList = false;

  }

  $scope.issue={};
  $scope.getMaterialStoreReturnList = function() {
    $loading.start('loader');
    $scope.viewReturnList=true;
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialStoreReturnList').success(function(data) {
      $scope.returnList1 = data;
      $scope.hideThis = true;
      $loading.finish('loader');
    });
  };

 $scope.hideIssueStoreList = function(){
    $scope.showIssueList = false;
    $scope.viewReturnList = true;
  };

 $scope.mrrStoreList = [];
  $scope.mrrList1 = [];
  $scope.materialList1 = [];
  $scope.getMRRStoreList = function() {
    $loading.start('loader');
   /* angular.forEach($scope.materialList1, function(id){
    $scope.materialList.rejected_quantity = parseFloat(id.quantity)- parseFloat(id.accepted_quantity);
    //$scope.materialList.
  console(materialList.rejected_quantity);
  });*/
    $http.get('functionFiles/getTransactionData.php?operType=getMRRStoreList').success(function(mrrStoreList) {
      $scope.mrrStoreList = mrrStoreList;
      $loading.finish('loader');
    });
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialRejectList1').success(function(mrrStoreList) {
      $scope.mrrList1 = mrrStoreList;
      $loading.finish('loader');
    });
  };

 $scope.mrr={};
$scope.getMrrDetails1 = function(mrr_id) { 
    $loading.start('loader');
   
    $scope.addStoreForm = true;
    $scope.addStoreData = false;
    //$scope.supplier=true;
    $scope.showIssueList =false;
    //$scope.viewUpdateButton1 =true;
   
    //$scope.mrr.rejection_date = $filter('date')(new Date(), 'dd-MM-yyyy');
    $http.get('functionFiles/getTransactionData.php?operType=getMrrDetails1&&mrr_id='+mrr_id).success(function(mrrdata) {
      $scope.mrr = mrrdata;
      //$scope.getMaterialReturnCode1();
     //$scope.getMaterialReturnCode2();
      $http.get('functionFiles/getTransactionData.php?operType=getMrrMaterials1&&mrr_id='+mrr_id).success(function(data) {
      $scope.materialList1 = data;
      $loading.finish('loader');
    });
    });
  };


  $scope.mrr={};
  $scope.materialList1={};  
   $scope.saveMrrReturn = function(fromAddMrr){    
    if(fromAddMrr){
      
      var formDataJson1 = JSON.stringify($scope.mrr);
      var formDataJson2 = JSON.stringify($scope.materialList1);
      //console.log($scope.mrr);
      //console.log($scope.materialList1);
      var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveTransactionData.php?operType=saveMrrReturn',
      data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
         }
      }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      if(data != 0){
        $loading.finish('loader');
        $scope.mrr={};
        $scope.materialList1=[];
        SweetAlert.swal("Material Returned Successfully...","","success");
        $scope.viewUpdateButton1 = false;
        $scope.viewReturnList = true;
        $scope.addStoreForm = false;
        $scope.getMaterialStoreReturnList();
        
      }else {
        SweetAlert.swal("Error In Creating Material...","","error");
       }      
        }); 
        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  };

  $scope.getMaterialCodeList1 = function() { 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialCodeList1').success(function(materialCodeList) {
      $scope.materialCodeList = materialCodeList;
      $loading.finish('loader');
    });
  };

 /*  
  $scope.getMaterialReturnCode1=function(){
    $loading.start('loader');
    $scope.date = $filter('date')(Date.now(), 'ddMMyy');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialReturnCode1').success(function(data) {
  
    if($scope.data== null || $scope.data ==''){
     $scope.mrr.return_no = '1';  
     $scope.mrr.return_no = 'RETS'+$scope.date+'-'+$scope.mrr.return_no;
     }else{    
    data = data.return_no.substr(11);
    $scope.mrr.return_no = data;
    $scope.mrr.return_no = parseInt(data)+1;  
    $scope.mrr.return_no.toString();
    $scope.mrr.return_no = 'RETS'+$scope.date+'-'+$scope.mrr.return_no;
     }  

    $loading.finish('loader');
    });
  };

 
  $scope.getMaterialReturnCode2=function(){
    $loading.start('loader');
    $scope.date = $filter('date')(Date.now(), 'ddMMyy');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialReturnCode2').success(function(data) {    
    if($scope.data == null || $scope.data ==''){
     $scope.mrr.rejected_return_no = '1';  
     $scope.mrr.rejected_return_no = 'RETR'+$scope.date+'-'+$scope.mrr.rejected_return_no;
     }else{    
    data = data.rejected_return_no.substr(11);
    $scope.mrr.rejected_return_no = data;
    $scope.mrr.rejected_return_no = parseInt(data)+1;  
    $scope.mrr.rejected_return_no.toString();
    $scope.mrr.rejected_return_no = 'RETR'+$scope.date+'-'+$scope.mrr.rejected_return_no;
     }  
    $loading.finish('loader');
    });
  };*/

  $scope.getMaterialReturnCodeStore=function(return_material_type){
    if (return_material_type == '1') {
    $scope.mrr.rejected_return_no = '';
    //$scope.ind.rejected_quantity = '';
    $loading.start('loader');
    $scope.date = $filter('date')(Date.now(), 'ddMMyy');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialReturnCode1').success(function(data) {
  
    if($scope.data== null || $scope.data ==''){
     $scope.mrr.return_no = '1';  
     $scope.mrr.return_no = 'RETS'+$scope.date+'-'+$scope.mrr.return_no;
     }else{    
    data = data.return_no.substr(11);
    $scope.mrr.return_no = data;
    $scope.mrr.return_no = parseInt(data)+1;  
    $scope.mrr.return_no.toString();
    $scope.mrr.return_no = 'RETS'+$scope.date+'-'+$scope.mrr.return_no;
     }  

    $loading.finish('loader');
    });

}else if (return_material_type == '2') {
    $scope.mrr.return_no = '';
    //$scope.ind.return_qty = '';
    $loading.start('loader');
    $scope.date = $filter('date')(Date.now(), 'ddMMyy');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialReturnCode2').success(function(data) {    
    if($scope.data == null || $scope.data ==''){
     $scope.mrr.rejected_return_no = '1';  
     $scope.mrr.rejected_return_no = 'RETR'+$scope.date+'-'+$scope.mrr.rejected_return_no;
     }else{    
    data = data.rejected_return_no.substr(11);
    $scope.mrr.rejected_return_no = data;
    $scope.mrr.rejected_return_no = parseInt(data)+1;  
    $scope.mrr.rejected_return_no.toString();
    $scope.mrr.rejected_return_no = 'RETR'+$scope.date+'-'+$scope.mrr.rejected_return_no;
     }  
    $loading.finish('loader');
    });
  } else if (return_material_type == '3') {
    $loading.start('loader');
    $scope.date = $filter('date')(Date.now(), 'ddMMyy');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialReturnCode1').success(function(data) {
  
    if($scope.data== null || $scope.data ==''){
     $scope.mrr.return_no = '1';  
     $scope.mrr.return_no = 'RETS'+$scope.date+'-'+$scope.mrr.return_no;
     }else{    
    data = data.return_no.substr(11);
    $scope.mrr.return_no = data;
    $scope.mrr.return_no = parseInt(data)+1;  
    $scope.mrr.return_no.toString();
    $scope.mrr.return_no = 'RETS'+$scope.date+'-'+$scope.mrr.return_no;
     }  

    $loading.finish('loader');
    });

  }
};


 $scope.checkQuantity1 = function(rejected_quantity,return_qty) {
    
    if(parseInt(rejected_quantity) < parseInt(return_qty))
    {
      SweetAlert.swal("Return qty must be less than Rejected qty...","","warning");
    }
  };

  /************** Madhuri Code Ends Here****************/

  /************************Sujata code starts here*********************/

// Inward gate entry
$scope.genrateInwardgateentryPDF = function(gate_entry_id){   
//$scope.gateid= gate_entry_id;
//console.log($scope.gate_entry_id);
var win = window.open('functionFiles/tcpdf/examples/inwardgateentry.php?gate_entry_id='+gate_entry_id);    
win.focus();  
};

//Outward gate entry
$scope.genrateOutwardgateentryPDF = function(outward_gate_entry_id){   
//$scope.gateid= gate_entry_id;
//console.log($scope.gateid);
var win = window.open('functionFiles/tcpdf/examples/outwardgateentry.php?outward_gate_entry_id='+outward_gate_entry_id);    
win.focus();  
};


//Material Issue
$scope.genrateMaterialissuePDF = function(contractor_inventory_id){  
//console.log($scope.contractor_inventory_id);  
var win = window.open('functionFiles/tcpdf/examples/materialissue.php?contractor_inventory_id='+contractor_inventory_id);    
win.focus();  
};

//Material Receipt Report
$scope.genrateMrrPDF = function(mrr_id){    
var win = window.open('functionFiles/tcpdf/examples/materialreceiptreport.php?mrr_id='+mrr_id);    
win.focus();  
};

//material return
$scope.genrateMaterialreturnPDF = function(contractor_inventory_id){    
var win = window.open('functionFiles/tcpdf/examples/materialreturn.php?contractor_inventory_id='+contractor_inventory_id);    
win.focus();  
};


//Material Rejection
$scope.genrateMaterialrejectionPDF = function(mrr_id){    
var win = window.open('functionFiles/tcpdf/examples/materialrejection.php?mrr_id='+mrr_id);    
win.focus();  
};



$scope.genrateReturnbystorePDF = function(mrr_id){    
var win = window.open('functionFiles/tcpdf/examples/returnbystore.php?mrr_id='+mrr_id);    
win.focus();  
};

//Material Consumption
$scope.genrateMaterialconsumptionPDF = function(material_consumption_code){    
var win = window.open('functionFiles/tcpdf/examples/materialconsumption.php?material_consumption_code='+material_consumption_code);    
win.focus();  
};

//Material Transfer Note
$scope.genrateMaterialtransfernotePDF = function(material_consumption_code){    
var win = window.open('functionFiles/tcpdf/examples/materialtransfernote.php?material_consumption_code='+material_consumption_code);    
win.focus();  
};

/****************************sujata ends starts here********************/
// $scope.equalAmount = function(approved_total_qty,issued_qty) {

//     if(parseFloat(approved_total_qty) < parseFloat(issued_qty))
//     {
//        SweetAlert.swal("Enter Valid quantity","","warning");
//        $scope.ind.issued_qty = 0;
//     }
//   };


})//end Transaction Controllers 
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


