var service = angular.module('services', [])
    .factory("ServerService", function($http, $q) {
        return {
            saveMasterRecords: function(linkData, formDataJson) {
                var result = $http({
                    method: 'POST',
                    url: 'functionFiles/saveMasterRecords.php?operType=' + linkData,
                    data: formDataJson,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).success(function(data, status, headers, config) {
                    //console.log(data);
                    return data;
                });
                return result;
            },
            saveRecords: function(linkData, formDataJson1, formDataJson2) {
                //console.log("formDataJson1 " + formDataJson1 + " , formDataJson2 " + formDataJson2);
                var result = $.ajax({
                    method: 'POST',
                    url: 'functionFiles/saveRecords.php?operType=' + linkData,
                    data: {
                        "formDataJson1": formDataJson1,
                        "formDataJson2": formDataJson2
                    },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).success(function(data, status, headers, config) {
                    //console.log(data);
                    return data;
                });
                return result;
            },
            saveRecordsMultipal: function(linkData, formDataJson1, formDataJson2, formDataJson3) {
                //console.log("formDataJson1 " + formDataJson1 + " , formDataJson2 " + formDataJson2 + " formDataJson3 " + formDataJson3);
                var result = $.ajax({
                    method: 'POST',
                    url: 'functionFiles/saveRecords.php?operType=' + linkData,
                    data: {
                        "formDataJson1": formDataJson1,
                        "formDataJson2": formDataJson2,
                        "formDataJson3": formDataJson3
                    },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).success(function(data, status, headers, config) {
                    //console.log(data);
                    return data;
                });
                return result;
            },
            getDataWithSingleParameter: function(linkData) {
                // alert("okkkkk");
                var deferred = $q.defer();
                $.ajax({
                    method: 'GET',
                    url: 'functionFiles/getVendorDetails.php?operType=' + linkData
                }).success(function(data, status, headers, config) {
                    deferred.resolve(data);
                });
                return deferred.promise;
            },
            getDataWithMultipleParameter: function(linkData, name) {
                console.log("getDataWithMultipleParameter called");
                var result = $.ajax({
                    method: 'GET',
                    url: 'functionFiles/getVendorDetails.php?operType=' + linkData,
                    data: {
                        'name': name
                    }
                }).success(function(data, status, headers, config) {
                    console.log("Service RES: "+JSON.stringify(data));
                    return data;
                });
                return result;
            }
        }

    })
     .factory('Excel',function($window){
        var uri='data:application/vnd.ms-excel;base64,',  
            template='<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64=function(s){return $window.btoa(unescape(encodeURIComponent(s)));},
            format=function(s,c){return s.replace(/{(\w+)}/g,function(m,p){return c[p];})};
        return {

            tableToExcel:function(tableId,worksheetName){
                var table=$(tableId),
                    ctx={worksheet:worksheetName,table:table.html()},
                    href=uri+base64(format(template,ctx));
                return href;
            }
        };
      })
   