angular.module('uploadjmcCTRL', [])
.config(function($stateProvider) {
  $stateProvider

 /* .state('home.ImportExcel', {
    url:'/ImportExcel',
    templateUrl: 'modules/Transaction/ImportExcel.html',
    controller:'uploadjmcCTRL'
  })

  .state('home.MaterialConsumption', {
    url:'/MaterialConsumption',
    templateUrl: 'modules/Transaction/MaterialConsumption.html',
    controller:'uploadjmcCTRL'
     })
   })*/

 /* .state('home.upload', {
    url: '/upload',
    templateUrl: "modules/UploadDocument/upload.html",
    controller:'uploadCTRLs'
  })


  .state('home.view', {
    url: '/view',
    templateUrl: "modules/UploadDocument/view.html",
    controller:'uploadCTRLs'
  })

});*/

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

 app.controller('uploadjmcCTRL',function($http, $scope, ServerService, $window, DTOptionsBuilder, $loading, loginService, $filter, $stateParams, $location, Excel, $timeout,fileUpload,SweetAlert) {
  
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
      var bomNumber;
    $http.get('functionFiles/getMaster.php?operType=getBOMNumber').success(function(data) {
      var str = data.replace(/\s+/g, '');
      if(str == ''){
        bomNumber = 'BOM0001';
      } else {
        var codeNumber = parseInt(str.slice(3)) + 1;
        var bomNumberInString = codeNumber.toString();

        if(bomNumberInString.length == 1){
          bomNumber = 'BOM000' + bomNumberInString;
        }else if(bomNumberInString.length == 2){
          bomNumber = 'BOM00' + bomNumberInString;
        }else if(bomNumberInString.length == 3){
          bomNumber = 'BOM0' + bomNumberInString;
        } else {
          bomNumber = 'BOM' + bomNumberInString;
        }
      }
      $scope.excel.bom_number = bomNumber;
    });
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
     //   alert( JSON.stringify($scope.consumption));
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
     $scope.addNewEntryForm=true;
     $scope.viewList=false;
    $loading.finish('loader');
    });
  };

   $scope.getMaterialConsumptionList = function() {// get product List for complaint close 
    $loading.start('loader');
    /*$("#updateField" ).show();*/
    $scope.viewList = true;
  $http.get('functionFiles/uploadExcel.php?operType=getMaterialConsumptionList').success(function(consumptionList) {
      $scope.consumptionList = consumptionList;
      $loading.finish('loader');
    });
  };

  $scope.getMaterialConsumptionDetails = function(material_consumption_code) {// get product List for complaint close 
    $loading.start('loader');
    $scope.addNewEntryForm = false;
    $scope.viewUpdateField1 = true;
    $scope.viewList = false;
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
    //   alert("myfile"+$scope.myFile);
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
       SweetAlert.swal("Material Consumption Saved Successfully...","","success");
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
       SweetAlert.swal("Please Enter a Valid Data...","","error");
      }

             var file = $scope.myFile;
            // alert("ffffff"+JSON.stringify(file));
              var uploadUrl = 'functionfiles/uploadExcel.php?operType=uploadFile&&formDataJson1=' + formDataJson1 + '';
             var msg = fileUpload.uploadFileToUrl(file, uploadUrl,formDataJson1,msg);
        
    }

    $scope.hideConsumptionForm = function(){
    $scope.viewUpdateField1 = false;
    $scope.addNewEntryForm = false;
    $scope.viewList = true;
    $("#newBtn" ).show();
  };

  $scope.consumptionApproval = function(){
    
  // $scope..approved_by = loginService.getUserName();
    //  $scope.indent.updated_by = loginService.getUserName();
      //$scope.indent.user_role = loginService.getUserRole();
      $scope.consumption.approved_by=loginService.getUserRole();

//alert("kkk");
      var formDataJson1 = JSON.stringify($scope.consumptionheader);
      var formDataJson2 = JSON.stringify($scope.consumptionheaderList);

     // console.log("ch"+formDataJson1);
      //console.log("chl"+formDataJson2);
      var result = $.ajax({
        method: 'POST',
        url: 'functionFiles/uploadExcel.php?operType=consumptionApproval',
        data: {
          'formDataJson1': formDataJson1,
          'formDataJson2': formDataJson2
        }
      }).success(function(data, status, headers, config) {
      //  $scope.hideAddIndentForm();
        $loading.finish('loader');
       
       if(data != 0){
        console.log("data"+data);
        $loading.finish('loader');
       SweetAlert.swal("Material Consumption Approved Successfully...","","success");
        $scope.getMaterialConsumptionList();
        $scope.viewUpdateField1 =false;
        /* $scope.consumptionheader= {};
          $scope.manual = [];       
    $scope.addNewEntryForm = false;
    $("#newBtn" ).show();*/
      }else {
        SweetAlert.swal("Error In Approved Consumption...","","error");
       }      
      });        
  }
  /********************** Suraj Code Ends Here**************/
 /*------------------------------Tarun------------*/

  $scope.getMaterialIssueNumberList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialIssueNumberList').success(function(MaterialIssueList) {
      $scope.MaterialIssueList = MaterialIssueList;
      console.log("kkkk"+$scope.MaterialIssueList);
    });
  };

  $scope.consumptionquantity = function(issued_qty,actual_qty,index) {
    
    if(parseInt(issued_qty) < parseInt(actual_qty))
    {
      SweetAlert.swal("Actual Quantity must be less than Issued Quantity...","","warning");

      $scope.indentListContractor[index].actual_qty =  $scope.indentListContractor[index].issued_qty;
    }
  };

$scope.getActivityNameListforConsumption = function(site_id) {// get product List for complaint close 
    $loading.start('loader');

     angular.forEach($scope.siteNameList,function(it){
      if(it.site_id == site_id){
        $scope.consumption.location = it.site_location;
      }
    })
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

   $scope.getProjectNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getIndent.php?operType=getProjectNameList').success(function(projectNameList) {
      $scope.projectNameList = projectNameList;
      $loading.finish('loader');
    });
  };

 
$scope.getSiteNameList = function(project_id) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getSiteNameList&&project_id='+project_id).success(function(siteNameList) {
      $scope.siteNameList = siteNameList;
    console.log($scope.siteNameList);
      $loading.finish('loader');
    });
  };

   $scope.getMaterialListContractorforConsumption = function(contractor_id,location) {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getMaterialListContractorforConsumption&&contractor_id='+contractor_id).success(function(indentListContractor) {
      $scope.indentListContractor = indentListContractor;
      $scope.materialtable=true;
      $scope.excelsubmitbtn=true;
      console.log( "jjjjj"+$scope.indentListContractor)
      $loading.finish('loader');
    });
  };
 

  $scope.getActivityNameList = function() {// get product List for complaint close 
    $loading.start('loader');
    $http.get('functionFiles/getTransactionData.php?operType=getActivityNameList').success(function(activityNameList) {
      $scope.activityNameList = activityNameList;
      console.log($scope.activityNameList);
      $loading.finish('loader');
    });
  };
 /*------------------------------Tarun------------*/



    });

});