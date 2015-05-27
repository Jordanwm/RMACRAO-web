angular.module('exhibitorApp', [])

.controller('IndexCtrl', function($scope, $http, $window){
	$scope.delete = function(exhibitor){
		if(confirm("Are you sure that you want to delete " + exhibitor.name + "?")){
			$http.delete('/exhibitors/' + exhibitor.id).success(function(data){
				$window.location.href = "/exhibitors";
			});
		}
	};
})

.controller('MainCtrl', function($scope, $http, $window){
	$scope.staff = [];
	$scope.err = "";
	$scope.exhibitor = {};
	$scope.hideAlert = function(){
		$scope.err = "";
	};
	$scope.setExhibitor = function(exhibitor){
		$scope.exhibitor = exhibitor;
		$scope.staff = exhibitor.staff;
	};
	$scope.addStaff = function(){
		$scope.modalTitle = "Add New Staff Member:";
		$scope.modalSubmitBtn = "Add Staff Member";
		$scope.name = '';
		$scope.title = '';
	};
	$scope.editStaff = function(staff){
		$scope.modalTitle = "Edit Staff Member:";
		$scope.modalSubmitBtn = "Update Member";
		$scope.name = staff.name;
		$scope.title = staff.title;
		$scope.id = staff.id;
	};
	$scope.addMember = function(mem){
		if ($scope.id) {
			$scope.staff.forEach(function(s){
				if (s.id == $scope.id) {
					s.name = $scope.name;
					s.title = $scope.title;
				}
			});
		} else {
			$scope.staff.push(mem);
		}
		
		$('#staffForm').modal('hide');

		$scope.name = '';
		$scope.title = '';
		$scope.id = null;
	};
	$scope.removeStaff = function(s) {
		if(confirm("Are you sure you want to delete " + s.name + "?")){
			index = $scope.staff.indexOf(s);
			$scope.staff.splice(index, 1);
		}
		return;
	};
	$scope.submitForm = function(exhibitor, staff, type){
		if (!exhibitor.name || exhibitor.name === "") {
			$scope.err = "Please add a name";
			return;
		} else if (!exhibitor.address || exhibitor.address === "") {
			$scope.err = "Please add an address";
			return;
		} else if (!exhibitor.city || exhibitor.city === "") {
			$scope.err = "Please add a city";
			return;
 		} else if (!exhibitor.state || exhibitor.state === "") {
 			$scope.err = "Please add a state";
 			return;
 		} else if (!exhibitor.zip || exhibitor.zip === "") {
 			$scope.err = "Please add a zip code";
 			return;
 		} else if (!exhibitor.description || exhibitor.description === "") {
 			$scope.err = "Please add a description";
 			return;
 		} else if (staff.length < 1) {
 			$scope.err = "Please add at least one staff member";
 			return;
 		} else {
			exhibitor.staff = staff;
			if (type === "put") {
				$http.put('/exhibitors/' + exhibitor.id, exhibitor).success(function(data){
					$window.location.href = '/exhibitors';
				});
			} else {
				$http.post('/exhibitors', exhibitor).success(function(data){
					$window.location.href = '/exhibitors';
				});
			}
 		}
	};
});