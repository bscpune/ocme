'use strict';
app.factory('loginService', function($http, $location, sessionService, $cookieStore, $loading, $state){
  var routespermission = '';
  return{
    login: function(formDataJson, scope) {
      $loading.start('loader');
      var result = $.ajax({
        method: 'GET',
        url: 'functionFiles/getLogin.php?operType=login',
        data: {
           'formDataJson': formDataJson
        }
      }).success(function(data, status, headers, config) {
        if (data == null || data == '' ){
          $loading.finish('loader');
          SweetAlert.swal("ENTER VALID USER INFORMATION...!","","warning");
        }else{
          console.log("data---------"+JSON.stringify(data));
          if(data[0] != ''){
            $http.get('functionFiles/getLogin.php?operType=createSesssionLogin').success(function(sessionId) {
              sessionService.set('uid',sessionId['session_id']);
              // sessionService.set('uid',12345);     

              switch('developer'){  
                case 'developer':
                  $state.go('home', null, { location: true });
                  $state.go('home.UserDash', null, { location: true });
                  $location.path('/UserDash');
                  routespermission = "/UserDash";
                break;
              }
              $loading.finish('loader');
            });
      
            sessionStorage.setItem("routeurl", routespermission);
            $cookieStore.put("user_name",data.user_name);
            $cookieStore.put("user_fullname",data.user_fullname);
            $cookieStore.put("user_role_id",data.user_role_id);
            $cookieStore.put("user_role",data.user_role);
            $cookieStore.put("dept_id",data.dept_id);
            $cookieStore.put("dept_name",data.dept_name);
            $cookieStore.put("user_location",data.user_location);
            $cookieStore.put("mobile_number",data.mobile_number);

            // sessionStorage.setItem("routeurl", routespermission);
            // $cookieStore.put("user_role",data[0]['user_role']);
            // $cookieStore.put("user_fullname",data[0]['user_fullname']);
            // $cookieStore.put("user_name",data[0]['user_name']);
            // $cookieStore.put("mobile_number",data[0]['mobile_number']);
            // $cookieStore.put("branch",data[0]['BRANCH']);
            // $cookieStore.put("asc_name",data[0]['ASC_NAME']);
            // $cookieStore.put("USR_ASC_NAME",data[0]['USR_ASC_NAME']);
          }
        }
      });
    },
    
    logout:function(){
      sessionService.destroy('uid');
      $state.go('login', null, { location: false });
      $location.path('/login');
      $cookieStore.put("user_name",'Unauthorised');
      $cookieStore.put("user_fullname",'Unauthorised');
      $cookieStore.put("user_role_id",'Unauthorised');
      $cookieStore.put("user_role",'Unauthorised');
      $cookieStore.put("dept_id",'Unauthorised');
      $cookieStore.put("dept_name",'Unauthorised');
      $cookieStore.put("user_location",'Unauthorised');
      $cookieStore.put("mobile_number",'Unauthorised');
    },
    
    islogged:function(){
      var $checkSessionServer=$http.post('functionFiles/data/check_session.php');
      return $checkSessionServer;
    },

    url:function(){
      return sessionStorage.routeurl; 
    },

    getUserName:function(){
      return $cookieStore.get('user_name');       
    },

    getUserRoleId:function(){
      return $cookieStore.get('user_role_id');       
    },

    getUserRole:function(){
      return $cookieStore.get('user_role');       
    },

    getFullName:function(){
      return $cookieStore.get('user_fullname');       
    },

    getDeptId:function(){
      return $cookieStore.get('dept_id');       
    },

    getDeptName:function(){
      return $cookieStore.get('dept_name');       
    },

    getMobNumber:function(){
      return $cookieStore.get('mobile_number');       
    },

  }
});