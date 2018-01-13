angular.module('IndentControllers', [])

.config(function($stateProvider) {
  $stateProvider
  
  .state('home.IndentCreation', {
    url:'/IndentCreation',
    templateUrl: 'modules/Indent/IndentCreation.html',
    controller:'IndentCtrl'
  })

 .state('home.ExternalCreation', {
    url:'/ExternalCreation',
    templateUrl: 'modules/Indent/ExternalCreation.html',
    controller:'IndentCtrl'
  })

  .state('home.MaterialStock', {
    url:'/MaterialStock',
    templateUrl: 'modules/Indent/MaterialStock.html',
    controller:'IndentCtrl'
  })

  .state('home.IndentApproval', {
    url:'/IndentApproval',
    templateUrl: 'modules/Indent/IndentApproval.html',
    controller:'IndentCtrl'
  })

  })
 
.controller('IndentCtrl', function($http, $state, $scope,$cookieStore, ServerService, $window, DTOptionsBuilder, $loading, loginService, $filter, $stateParams, $location, Excel, $timeout,SweetAlert,$interval) {
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
  
  $scope.userRoleId = loginService.getUserRoleId();
  $scope.userRole = loginService.getUserRole();



  $scope.contractorNameList = [];
  $scope.getContractorNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getContractorNameList').success(function(contractorNameList) {
      $scope.contractorNameList = contractorNameList;
      $loading.finish('loader');
    });
  };

$scope.siteLocationList = [];
  $scope.getSiteLocationList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getSiteLocationList').success(function(siteLocationList) {
      $scope.siteLocationList = siteLocationList;
      $loading.finish('loader');
    });
  };
  $scope.indentIdList = [];
  $scope.getIndentIdList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getIndentIdList').success(function(indentIdList) {
      $scope.indentIdList = indentIdList;
      $loading.finish('loader');
    });
  };

  $scope.projectNameList = [];
  $scope.getProjectNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getProjectNameList').success(function(projectNameList) {
      $scope.projectNameList = projectNameList;
      $loading.finish('loader');
    });
  };

$scope.storeNameList = [];
  $scope.getStoreNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getStoreNameList').success(function(storeNameList) {
      $scope.storeNameList = storeNameList;
      $loading.finish('loader');
    });
  };

/*****************************Amit w code starts here******************************/
$scope.userRole = loginService.getUserRole();

  $scope.indent ={};
  $scope.indentList = [];
  $scope.getIndentList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getIndentList').success(function(indentList) {
      if(indentList == ''){
        $loading.finish('loader');
      } else {
        $scope.indentList = indentList;
        $loading.finish('loader');
      }      
    });
  };

  $scope.addNewIndentForm = false;
  $scope.addNewIndent = function(){
    
    $scope.addNewIndentForm = true;
    $scope.addNewIndentData = true;
    $scope.addNewIndentData1 = false;
    $scope.addNewIndentData2=false;
    $scope.addNewIndentDataupdate = true;
    $scope.indent = {};
    $scope.indentMaterial = {};
    $scope.indentMaterialList = [];
    $scope.indent.indent_date = $filter('date')(new Date(), 'dd-MM-yyyy');
   };  

    $scope.checkInternalIndentType = function(){
      
      $http.get('functionFiles/getIndent.php?operType=getInternalIndentCode').success(function(data) {
      var indentCode;
      var finalIndentCode;
      var date = new Date();
      var currentDay = date.getDay();
      var currentMonth = date.getMonth() + 1;
      var currentYear = date.getFullYear().toString().substr(-2);
      var nextYear = parseInt(currentYear) + 1;
      var previousYear = parseInt(currentYear) - 1;
         if(data.trim() == ''){
        if(currentMonth == 1 || currentMonth == 2 || currentMonth == 3){
          finalIndentCode = 'I-1/' + previousYear + '-' + currentYear;
        } else {
          finalIndentCode = 'I-1/' + currentYear + '-' + nextYear;
        }
      } else {

        var str = data;    
        var string = str.split('/').shift().split('-').pop();
        indentCode = parseInt(string) + 1;

        if(currentMonth == 1 || currentMonth == 2 || currentMonth == 3){
          finalIndentCode = 'I-' + indentCode + '/' + previousYear + '-' + currentYear;
        } else {
          var temp = 'I-1/' + currentYear + '-' + nextYear;
          if(currentMonth == 4 && data != temp){
            finalIndentCode = 'I-1/' + currentYear + '-' + nextYear;
          } else {
            finalIndentCode = 'I-' + indentCode + '/' + currentYear + '-' + nextYear;
          }
        }
      }
      $scope.indent.indent_code = finalIndentCode;
      });
    };

    $scope.checkExternalIndentType = function(){
      $http.get('functionFiles/getIndent.php?operType=getExternalIndentCode').success(function(data) {
      var indentCode;
      var finalIndentCode;
      var date = new Date();
      var currentDay = date.getDay();
      var currentMonth = date.getMonth() + 1;
      var currentYear = date.getFullYear().toString().substr(-2);
      var nextYear = parseInt(currentYear) + 1;
      var previousYear = parseInt(currentYear) - 1;
         if(data.trim() == ''){
        if(currentMonth == 1 || currentMonth == 2 || currentMonth == 3){
          finalIndentCode = 'E-1/' + previousYear + '-' + currentYear;
        } else {
          finalIndentCode = 'E-1/' + currentYear + '-' + nextYear;
        }
      } else {

        var str = data;    
        var string = str.split('/').shift().split('-').pop();
        indentCode = parseInt(string) + 1;

        if(currentMonth == 1 || currentMonth == 2 || currentMonth == 3){
          finalIndentCode = 'E-' + indentCode + '/' + previousYear + '-' + currentYear;
        } else {
          var temp = 'E-1/' + currentYear + '-' + nextYear;
          if(currentMonth == 4 && data != temp){
            finalIndentCode = 'E-1/' + currentYear + '-' + nextYear;
          } else {
            finalIndentCode = 'E-' + indentCode + '/' + currentYear + '-' + nextYear;
          }
        }
      }
      $scope.indent.indent_code = finalIndentCode;
      });
    
    
   
  };


  $scope.hideAddIndentForm = function() {
    $scope.addNewIndentForm = false;
    $scope.indent= {};
    //$scope.getIndentList();
  };

 $scope.projectNameList = [];
  $scope.getProjectNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getProjectNameList').success(function(projectNameList) {
      $scope.projectNameList = projectNameList;
      $loading.finish('loader');
    });
  };


  $scope.getManagerName = function(project_id){
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getProjectDetails&&project_id='+project_id).success(function(data) {
      $scope.indent.manager_name = data[0].manager_name;
      //$scope.quotation.manager_name = data[0].manager_name;
      $loading.finish('loader');
    });
  }
/****************** amit code ends here********************/
  
/*****************************Sujata code starts here******************************/


  $scope.materialCodeList = [];
  $scope.getMaterialCodeList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getMaterialCodeList').success(function(materialCodeList) {
      $scope.materialCodeList = materialCodeList;
      $loading.finish('loader');
    });
  };

  // $scope.indent = {};
  // $scope.indentMaterial = {};
  // $scope.indentMaterialList = [];
$scope.indentMaterial ={};
  $scope.getMaterialCodeDetails = function(material_code){
    $loading.start('loader');
    console.log("hey");
    $http.get('functionFiles/getIndent.php?operType=getMaterialCodeDetails&&material_code='+material_code).success(function(data) {
     console.log("4444"+data);
     
        $scope.indentMaterial.unit_of_measurment = data.unit_of_measurment;
        $scope.indentMaterial.material_name = data.material_name;
        $scope.indentMaterial.material_id = data.material_id;
        $scope.indentMaterial.material_code = data.material_code;
        $scope.indentMaterial.material_description = data.material_description;
        $loading.finish('loader');
      
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
    
    $scope.indentMaterialList.push({
      "material_id": $scope.indentMaterial.material_id,
      "material_name": $scope.indentMaterial.material_name,
      "material_code": $scope.indentMaterial.material_code,
      "material_description":$scope.indentMaterial.material_description,
      "unit_of_measurment": $scope.indentMaterial.unit_of_measurment,
      "indent_material_qty": $scope.indentMaterial.indent_material_qty,
      "issued_qty": $scope.indentMaterial.issued_qty,
      
    });
  };

  $scope.deleteIndentMaterial = function(index){ 
    $scope.indentMaterialList.splice(index,1);
  };

  $scope.saveIndent = function(fromAddIndent){
    if(fromAddIndent){
     /* if($scope.indent.bom_id =='' || $scope.indent.bom_id== null){
        $scope.indent.bom_id =null;
      }else{
        $scope.indent.bom_id = $scope.indent.bom_id ;
      }*/
      var total_quantity = 0;
      if($scope.indentMaterialList.length == 0){
        SweetAlert.swal("Please Add Atleast One Material...","","warning");
        $loading.finish('loader');
      } else {
        angular.forEach($scope.indentMaterialList,function(it){
          total_quantity = parseInt(total_quantity) + parseInt(it.quantity);
        });
        $scope.indent.total_quantity = total_quantity;

        $scope.indent.created_by = loginService.getUserName();
        var formDataJson1 = JSON.stringify($scope.indent);
        var formDataJson2 = JSON.stringify($scope.indentMaterialList);
        //console.log(formDataJson1);
        //console.log(formDataJson2);
        var result = $.ajax({
          method: 'POST',
          url: 'functionFiles/saveIndentRecords.php?operType=saveIndent',
          data: {
            'formDataJson1': formDataJson1,
            'formDataJson2': formDataJson2
          }
        }).success(function(data, status, headers, config) {
          $loading.finish('loader');
          $scope.hideAddIndentForm();
          $scope.getIndentList();
          if(data != 0){
            SweetAlert.swal("Indent Created Successfully...","","success");
          }else {
            SweetAlert.swal("Error In Creating Indent...","","error");
          }   
          $scope.indent=[]; 
           $scope.indentMaterial=[];  
        });        
      }
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  }

  $scope.getIndentDetails = function(indent_id){
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getIndentDetails&&indent_id='+indent_id).success(function(data) {
      $scope.indent = data;
      $scope.indent.total_quantity = parseInt(data.total_quantity);
      $scope.indent.indent_date = $filter('date')(data.indent_date, 'dd-MM-yyyy');
      $scope.addNewIndentForm = true;
      $scope.addNewIndentData = true;

      $http.get('functionFiles/getIndent.php?operType=getIndentMaterialList&&indent_id='+indent_id).success(function(indentMaterialList) {
        $scope.indentMaterialList = indentMaterialList;
      });
      $loading.finish('loader');
    });
  }

  $scope.updateIndent = function(fromAddIndent){
    if(fromAddIndent){
      var total_quantity = 0;
      angular.forEach($scope.indentMaterialList,function(it){
        total_quantity = parseInt(total_quantity) + parseInt(it.quantity);
      });

      $scope.indent.updated_by = loginService.getUserName();

      var formDataJson1 = JSON.stringify($scope.indent);
      var formDataJson2 = JSON.stringify($scope.indentMaterialList);
      var result = $.ajax({
        method: 'POST',
        url: 'functionFiles/saveIndentRecords.php?operType=updateIndent',
        data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
        }
      }).success(function(data, status, headers, config) {
        $loading.finish('loader');
        $scope.hideAddIndentForm();
        $scope.getIndentList();
        if(data ==1 ){
          SweetAlert.swal("Indent Updated Successfully...","","success");
        }else {
          SweetAlert.swal("Error In Updating Indent...","","error");
        }      
      });        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  }

$scope.updateExternalIndent = function(fromAddIndent){
    if(fromAddIndent){
      var total_quantity = 0;
      angular.forEach($scope.indentMaterialList,function(it){
        total_quantity = parseInt(total_quantity) + parseInt(it.quantity);
      });

      $scope.indent.updated_by = loginService.getUserName();

      var formDataJson1 = JSON.stringify($scope.indent);
      var formDataJson2 = JSON.stringify($scope.indentMaterialList);
      var result = $.ajax({
        method: 'POST',
        url: 'functionFiles/saveIndentRecords.php?operType=updateIndent',
        data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
        }
      }).success(function(data, status, headers, config) {
        $loading.finish('loader');
        $scope.hideAddIndentForm();
        $scope.getExternalIndentList();
        if(data ==1 ){
          SweetAlert.swal("Indent Updated Successfully...","","success");
        }else {
          SweetAlert.swal("Error In Updating Indent...","","error");
        }      
      });        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  }


  $scope.deleteIndent = function(indent_id){
    $scope.indent.deleted_by = loginService.getUserName();
    $scope.indent.indent_id = indent_id;

    var formDataJson1 = JSON.stringify($scope.indent);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveIndentRecords.php?operType=deleteIndent',
      data: {
        'formDataJson1': formDataJson1
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getIndentList();
      if(data == 1){
        SweetAlert.swal("Indent Deleted Successfully...","","success");
      }else {
        SweetAlert.swal("Error In Deleting Indent...","","error");
      }      
    });        
  }

  $scope.deleteExtIndent = function(indent_id){
    $scope.indent.deleted_by = loginService.getUserName();
    $scope.indent.indent_id = indent_id;

    var formDataJson1 = JSON.stringify($scope.indent);
    var result = $.ajax({
      method: 'POST',
      url: 'functionFiles/saveIndentRecords.php?operType=deleteIndent',
      data: {
        'formDataJson1': formDataJson1
      }
    }).success(function(data, status, headers, config) {
      $loading.finish('loader');
      $scope.getExternalIndentList();
      if(data == 1){
        SweetAlert.swal("Indent Deleted Successfully...","","success");
      }else {
        SweetAlert.swal("Error In Deleting Indent...","","error");
      }      
    });        
  }

//Indent Approval

$scope.approveIndent = function(fromIndentApproval){
    if(fromIndentApproval){
      var total_quantity = 0;
      angular.forEach($scope.indentMaterialList,function(it){
          total_quantity = parseInt(total_quantity) + parseInt(it.quantity);
      });
   $scope.indent.approved_by = loginService.getUserName();
      $scope.indent.updated_by = loginService.getUserName();
      $scope.indent.user_role = loginService.getUserRole();
      //$scope.indent.approved_by=loginService.getUserRole();


      var formDataJson1 = JSON.stringify($scope.indent);
      var formDataJson2 = JSON.stringify($scope.indentMaterialList);

      console.log($scope.indent);
      console.log($scope.indentMaterialList);
      var result = $.ajax({
        method: 'POST',
        url: 'functionFiles/saveIndentRecords.php?operType=approveIndent',
        data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
        }
      }).success(function(data, status, headers, config) {
        $scope.hideAddIndentForm();
        $loading.finish('loader');
        $scope.getIndentList();
        if(data == 1){
          SweetAlert.swal("Indent Approved Successfully...","","success");   
          $scope.getIndentList();
        }else {
          SweetAlert.swal("Error In Approving Indent...","","error");          
        }      
      });        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  }


  $scope.rejectIndent = function(fromIndentApproval){
    if(fromIndentApproval){
      var total_quantity = 0;
      angular.forEach($scope.indentMaterialList,function(it){
          total_quantity = parseInt(total_quantity) + parseInt(it.quantity);
      });
    $scope.indent.approved_by = loginService.getUserName();
      $scope.indent.updated_by = loginService.getUserName();
      $scope.indent.user_role = loginService.getUserRole();

      var formDataJson1 = JSON.stringify($scope.indent);
      var formDataJson2 = JSON.stringify($scope.indentMaterialList);
      var result = $.ajax({
        method: 'POST',
        url: 'functionFiles/saveIndentRecords.php?operType=rejectIndent',
        data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
        }
      }).success(function(data, status, headers, config) {
        $loading.finish('loader');
        $scope.hideAddIndentForm();
          $scope.getIndentList();
        if(data == 1){
          SweetAlert.swal("Indent Rejected Successfully...","","success");          
        }else {
          SweetAlert.swal("Error In Rejecting Indent...","","error");          
        }      
      });        
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  }

  
  $scope.indentListForEnquiry = [];
  $scope.getIndentListForEnquiry = function() {
    $loading.start('loader');
    $http.get('functionFiles/getDataMM.php?operType=getIndentListForEnquiry').success(function(indentList) {
      if(indentList == ''){
        $loading.finish('loader');
      } else {
        $scope.indentListForEnquiry = indentList;
        $loading.finish('loader');
      }      
    });
  };

$scope.addApproveIndentForm = false;
  $scope.addApproveIndent = function(){
    $scope.addApproveIndentForm = true;
    $scope.addApproveIndentData = true;
    $scope.indent = {};
  }


  $scope.indent ={};
  $scope.indentList = [];
  $scope.getIndentList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getIndentList').success(function(indentList) {
      if(indentList == ''){
        $loading.finish('loader');
      } else {
        $scope.indentList = indentList;
        $loading.finish('loader');
      }      
    });
  };

  $scope.getExternalIndentList = function() {
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getExternalIndentList').success(function(indentList) {
      if(indentList == ''){
        $loading.finish('loader');
      } else {
        $scope.indentList = indentList;
        $loading.finish('loader');
      }      
    });
  };

  // $scope.Indent={};
  // $scope.updateIndent = function(fromAddIndent){
  //   if(fromAddIndent){
  //     var total_quantity = 0;
  //     $scope.indent.updated_by = loginService.getUserName();

  //     var formDataJson1 = JSON.stringify($scope.indent);
  //     var formDataJson2 = JSON.stringify($scope.indentMaterialList);
  //      console.log($scope.indent);
  //     console.log($scope.indentMaterialList);

  //     var result = $.ajax({
  //       method: 'POST',
  //       url: 'functionFiles/saveIndentRecords.php?operType=updateIndent',
  //       data: {
  //         'formDataJson1': formDataJson1,
  //         'formDataJson2': formDataJson2
  //       }
  //     }).success(function(data, status, headers, config) {
  //       $loading.finish('loader');
  //       $scope.hideAddIndentForm();
        
  //       if(data == 1){
  //         SweetAlert.swal("Indent Approved Successfully...","","success");
  //         $scope.getIndentList();
  //       }else {
  //         SweetAlert.swal("Error In Approving Indent...","","error");
  //       }      
  //     });        
  //   } else {
  //     SweetAlert.swal("Please Enter Valid Data...","","warning");
  //     $loading.finish('loader');
  //   }
  // }

  $scope.getIndentDetailsforAP = function(indent_code){
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getIndentDetailsforAP&&indent_code='+indent_code).success(function(data) {
      //console.log(data);
      $scope.indent = data;
      $scope.addNewIndentForm = true;
      $scope.tabled = true;
    $http.get('functionFiles/getIndent.php?operType=getIndentMaterialListforAP&&indent_code='+indent_code).success(function(indentMaterialList) {
      $scope.indentMaterialList = indentMaterialList;
  //console.log(JSON.stringify($scope.indentMaterialList));
      $loading.finish('loader');
    });
      });     
  };

/*$scope.getIndentMaterialListforAP = function(indent_code){
    $loading.start('loader');
    //console.log(indent_code);
    $http.get('functionFiles/getIndent.php?operType=getIndentMaterialListforAP&&indent_code='+indent_code).success(function(data) {
      console.log(data);
      $scope.indentMaterialList = data;
      $scope.addNewIndentForm = true;
      $loading.finish('loader');
      });     
  };*/

  $scope.getIndentDetailsforupdate = function(indent_code,material_code){
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getIndentListforupdate&&indent_code='+indent_code).success(function(data) {
     // console.log("88"+data);
      $scope.indent = data;
      //console.log( $scope.indent);
      if(data.bom_id != '' && data.bom_id != null){
        $scope.bomdata=true;
        $scope.bomcode=true;
        $scope.bomsoil=true;
        $scope.bomtower=true;
        $scope.bomnodata=false;
        $scope.bomnocode=false;
        $scope.bomnosoil=false;
        $scope.bomnotower=false;
        $scope.tabled = false;
         $scope.tabled2=true;
      }
      else{
         $scope.bomnodata=true;
        $scope.bomnocode=true;
        $scope.bomnosoil=true;
        $scope.bomnotower=true;
        $scope.bomdata=false;
        $scope.bomcode=false;
        $scope.bomsoil=false;
        $scope.bomtower=false;
         $scope.tabled = true;
         $scope.tabled2=false;
      }
      $scope.addNewIndentForm = true;
     
    
      $scope.addNewIndentDataupdate = false;
    $http.get('functionFiles/getIndent.php?operType=getIndentListMaterialforupdate&&indent_code='+indent_code).success(function(indentMaterialList) {
      $scope.indentMaterialList = indentMaterialList;
  //console.log(JSON.stringify($scope.indentMaterialList));
  $scope.addNewIndentData=true;
  $scope.addNewIndentData1=false;
  $scope.addNewIndentData2=true;
  $http.get('functionFiles/getIndent.php?operType=getMaterialIssuedQty1&&material_code='+material_code).success(function(data) {
      
     //console.log("4444"+JSON.stringify(data));
     $scope.indentMaterialList.issued_qty = data.issued_qty; 
        $loading.finish('loader');
      
    });
      $loading.finish('loader');
    });
      });     
  };

$scope.getIndentMaterialListforupdate = function(indent_code){
    $loading.start('loader');
    //console.log(indent_code);
    $http.get('functionFiles/getIndent.php?operType=getIndentMaterialListforAP&&indent_code='+indent_code).success(function(data) {
      console.log(data);
      $scope.indentMaterialList = data;
      $scope.addNewIndentForm = true;
      $loading.finish('loader');
      });     
  };


$scope.hideAddIndentForm = function() {
    $scope.addNewIndentForm = false;
    $scope.indent= {};
    //$scope.getIndentList();
  };

  // Inventory Stock

  $scope.materialstockList = [];
  $scope.getMaterialStockList = function(project_id,store_id,contractor_id) {
    console.log(project_id);
    console.log(store_id);
    console.log(contractor_id);
    $loading.start('loader');

    if(store_id == undefined && contractor_id==undefined){
    $http.get('functionFiles/getIndent.php?operType=getMaterialStockListPROSTO&&project_id='+project_id).success(function(materialstockList) {
      $scope.materialstockList = materialstockList;
      //console.log($scope.materialstockList);
      $loading.finish('loader');
       });
    }else if(contractor_id==undefined){
    $http.get('functionFiles/getIndent.php?operType=getMaterialStockListPROSTOINV&&project_id='+project_id+'&&store_id='+store_id).success(function(materialstockList) {
      $scope.materialstockList = materialstockList;
      //console.log($scope.materialstockList);
      $loading.finish('loader');
       });
    }else{
    $http.get('functionFiles/getIndent.php?operType=getMaterialContractorStockList&&contractor_id='+contractor_id).success(function(materialstockList) {
      $scope.materialstockList = materialstockList;
      //console.log($scope.materialstockList);
      $loading.finish('loader');
       });
  }
  };

$scope.getStoreList = [];
  $scope.getStoreList= function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getStoreList').success(function(storeNameList) {
      $scope.storeNameList = storeNameList;
      $loading.finish('loader');
    });
  };

  $scope.getStoreList1 = function(project_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getStoreList1&&project_id='+project_id).success(function(storeNameList) {
      $scope.storeNameList = storeNameList;
      $loading.finish('loader');
    });
  };

  
/********************** Sujata Code Ends Here**************/




/********************** Tarun Code Starts Here**************/
 /*$scope.getInternalIndent=function(project_id){
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getProjectNameList1&&project_id='+project_id).success(function(projectNameList) {
      $scope.projectNameList = projectNameList;
       $scope.project_code= projectNameList[0].project_code;
    alert("ppppp"+$scope.project_code)
     });
    $http.get('functionFiles/getIndent.php?operType=getInternalIndent').success(function(data) {
     
    if(data == null){
     $scope.indent.indent_code = '1';  
     $scope.indent.indent_code = 'I'+$scope.indent.indent_code;
     }else{    
    data = data.indent_code.substr(1);
    $scope.indent.indent_code = data;
    alert(data);
    $scope.indent.indent_code = parseInt(data)+1;  
    $scope.indent.indent_code.toString();
    $scope.indent.indent_code = 'I'+$scope.indent.indent_code;
     }  
    $loading.finish('loader');
    });
    };*/

$scope.getMultiSelect = function(){
var items = [{
        id: 1,
        label: "Indent Code"
    }, {
        id: 2,
        label: "Indent Date"
    }, {
        id: 3,
        label: "Contractor Name"
    }, {
        id: 4,
        label: "Site Location"
    }, {
        id: 5,
        label: "Approved status"
    }];
  
    $scope.example13data = items;
   }

   $scope.getmultiselect1 = function(value){
    if(value =='1'){
    alert("hiii");
   }}

     $scope.equalAmount = function(indent_material_qty,approved_total_qty,index) {

          if(parseFloat(indent_material_qty) < parseFloat(approved_total_qty))
    {
       SweetAlert.swal("Enter Valid quantity","","warning");
       $scope.indentMaterialList[index].approved_total_qty = $scope.indentMaterialList[index].indent_material_qty;

    }

    
  };

   $scope.equalquantity = function(required,indent_material_qty,index) {

    if(parseFloat(required) < parseFloat(indent_material_qty))
    {
       SweetAlert.swal("Enter Valid quantity","","warning");
       $scope.indentMaterialList[index].indent_material_qty = $scope.indentMaterialList[index].required;

    }

    
  };

    $scope.saveExternalIndent = function(fromAddIndent){
    if(fromAddIndent){
      var total_quantity = 0;
      if($scope.indentMaterialList.length == 0){
        SweetAlert.swal("Please Add Atleast One Material...","","warning");
        $loading.finish('loader');
      } else {
        angular.forEach($scope.indentMaterialList,function(it){
          total_quantity = parseInt(total_quantity) + parseInt(it.quantity);
        });
        $scope.indent.total_quantity = total_quantity;

        //$scope.indent.created_by = loginService.getUserName();
        var formDataJson1 = JSON.stringify($scope.indent);
        var formDataJson2 = JSON.stringify($scope.indentMaterialList);
        //console.log(formDataJson1);
        //console.log(formDataJson2);
        var result = $.ajax({
          method: 'POST',
          url: 'functionFiles/saveIndentRecords.php?operType=saveExternalIndent',
          data: {
            'formDataJson1': formDataJson1,
            'formDataJson2': formDataJson2
          }
        }).success(function(data, status, headers, config) {
          $loading.finish('loader');
          $scope.hideAddIndentForm();
          $scope.getExternalIndentList();
          if(data == 1){
            SweetAlert.swal("External Indent Created Successfully...","","success");
          }else {
            SweetAlert.swal("Error In Creating Indent...","","error");
          }      
        });        
      }
    } else {
      SweetAlert.swal("Please Enter Valid Data...","","warning");
      $loading.finish('loader');
    }
  }


 $scope.activityNameList1 = [];
  $scope.getActivityNameList1 = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getActivityNameList1').success(function(activityNameList1) {
      $scope.activityNameList1 = activityNameList1;
      $loading.finish('loader');
    });
  };

 $scope.activityNameList2 = [];
  $scope.getActivityNameList2 = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getActivityNameList2').success(function(activityNameList) {
      $scope.activityNameList = activityNameList;
      $loading.finish('loader');
    });
  };

   $scope.getSiteNameList1 = [];
  $scope.getSiteNameList1= function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getSiteNameList1').success(function(siteNameList) {
      $scope.siteNameList = siteNameList;
      $loading.finish('loader');
    });
  };

$scope.getSiteNameList = function(store_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getSiteNameList&&store_id='+store_id).success(function(siteNameList) {
      $scope.siteNameList = siteNameList;
      $loading.finish('loader');
    });
  };

$scope.getActivityNameList = function(project_id,store_id,site_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getActivityNameList&&project_id='+project_id).success(function(activityNameList) {
      $scope.activityNameList = activityNameList;

      /* $http.get('functionFiles/getIndent.php?operType=getSiteLocation&&site_id='+site_id).success(function(siteLocation) {
      $scope.indent.location_code = siteLocation;  
     consloe.log()
     */
      $loading.finish('loader');
    }); /*});*/
  };


  $scope.getBOMData = function(project_id,site_id,activity_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getBOMData&&project_id='+project_id+'&&site_id='+site_id+'&&activity_id='+activity_id).success(function(bomdata) {
      $scope.bomdata = bomdata;
      if($scope.bomdata != ''){
       $scope.indent.tower_type=bomdata[0].tower_type;
       $scope.indent.soil_type=bomdata[0].soil_type;
       $scope.indent.BOM_Code=bomdata[0].bom_number;
       $scope.indent.bom_name=bomdata[0].bom_name;
        $scope.indent.bom_id=bomdata[0].bom_id;
        alert($scope.bom_id);
       $scope.tabled=false;
        $scope.tabled2=true;
        $scope.bomdata=true;
        $scope.bomcode=true;
        $scope.bomsoil=true;
        $scope.bomtower=true;
}else{
  $scope.tabled=true;
        $scope.tabled2=false;
        $scope.bomnodata=true;
        $scope.bomdata=false;
        $scope.bomcode=false;
        $scope.bomsoil=false;
        $scope.bomtower=false;
        $scope.bomnocode=true;
        $scope.bomnosoil=true;
        $scope.bomnotower=true;
}
         $http.get('functionFiles/getIndent.php?operType=getBOMDataMaterial&&bom_id='+$scope.indent.bom_id).success(function(indentMaterialList) {
      $scope.indentMaterialList = indentMaterialList;
  console.log(JSON.stringify($scope.indentMaterialList));
      $loading.finish('loader');
    });
          });
  };

 $scope.indent ={};
  $scope.indentList = [];
  $scope.getIndentListforApproval = function() {
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getIndentListforApproval').success(function(indentList) {
      if(indentList == ''){
        $loading.finish('loader');
      } else {
        $scope.indentList = indentList;
        $loading.finish('loader');
      }      
    });
  };

/********************** Tarun Code Ends Here**************/

/*************************Sujata Code starts here*****************/
//Internal Indent
$scope.genrateIndentcreationPDF = function(indent_code){    
var win = window.open('functionFiles/tcpdf/examples/indentcreation.php?indent_code='+indent_code);    
win.focus();  
};


//Indent Approval
$scope.genrateIndentapprovalPDF = function(indent_code){    
var win = window.open('functionFiles/tcpdf/examples/indentapproval.php?indent_code='+indent_code);    
win.focus();  
};

//External Indent
$scope.genrateExternalcreationPDF = function(indent_code){    
var win = window.open('functionFiles/tcpdf/examples/externalcreation.php?indent_code='+indent_code);    
win.focus();  
};

/*****************************Sujata code ends here******************/
/*****************************amit code ends here******************/
$scope.indentMaterial ={};
  $scope.getMaterialIssuedQty = function(material_code,project_id,site_id,contractor_id,activity_id){
    console.log("project_id"+project_id);
    console.log("site_id"+site_id);
    console.log("activity_id"+activity_id);
    console.log("contractor_id"+contractor_id);
    $loading.start('loader');
    //console.log("hey");
    $http.get('functionFiles/getIndent.php?operType=getMaterialIssuedQty&&material_code='+material_code+'&&project_id='+project_id+'&&site_id='+site_id+'&&activity_id='+activity_id+'&&contractor_id='+contractor_id).success(function(data) {
      
     console.log("4444"+JSON.stringify(data));
     if(data.issued_qty==null){
        $scope.indentMaterial.issued_qty=0;
     }else{
     $scope.indentMaterial.issued_qty = data.issued_qty; 
        $loading.finish('loader');
      }
    });
  };
/*****************************amit code ends here******************/
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