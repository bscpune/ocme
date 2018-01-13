'use strict';
app.factory('SweetAlert', [ '$rootScope', function ( $rootScope ) {

	var swal = window.swal;

	//public methods
	var self = {

		swal: function ( arg1, arg2, arg3 ) {
			$rootScope.$evalAsync(function(){
				if( typeof(arg2) === 'function' ) {
					swal( arg1, function(isConfirm){
						$rootScope.$evalAsync( function(){
							arg2(isConfirm);
						});
					}, arg3 );
				} else {
					swal( arg1, arg2, arg3 );
				}
			});
		},
		success: function(title, message) {
			$rootScope.$evalAsync(function(){
				swal( title, message, 'success' );
			});
		},
		error: function(title, message) {
			$rootScope.$evalAsync(function(){
				swal( title, message, 'error' );
			});
		},
		warning: function(title, message) {
			$rootScope.$evalAsync(function(){
				swal( title, message, 'warning' );
			});
		},
		info: function(title, message) {	
			$rootScope.$evalAsync(function(){
				swal( title, message, 'info' );
			});
		},
		confirm: function(title, message, callback) {
			  swal({
			    title: "Are you sure?",
			    text: "Do you really want to Delete!",
			    type: "warning",
			    showCancelButton: true,
			    confirmButtonColor: '#DD6B55',
			    confirmButtonText: 'Ok',
			    cancelButtonText: "Cancel",
			    closeOnConfirm: true,
			    closeOnCancel: true
			  },
			  function(isConfirm) {
			      callback(isConfirm)
			  });
		}
	};
	
	return self;
}]);