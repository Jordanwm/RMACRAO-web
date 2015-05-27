angular.module('app.controllers', ['app.services'])

.controller('MainCtrl', function(Days, $scope){
	//Days
	$scope.days = Days.days;
	$scope.selectedDay = null;
	$scope.dayEdit = null;
	$scope.dayError = "";
	var validateDay = function (day){
		if ( !day.day || day.day === ''){
			$scope.dayError = "Please include the day";
			return false;
		} else {
			$scope.dayError = "";
			return true;
		}
	}
	$scope.addDay = function() {
		day = {day:$scope.newDay, sessions:[]};
		if ( !validateDay(day) ){return;}

		Days.createDay(day);
		$scope.newDay = '';
	};
	$scope.editDay = function(day){
		$scope.dayEdit = angular.copy(day);
	};
	$scope.updateDay = function(){
		if ( !validateDay($scope.dayEdit) ){return;}

		Days.updateDay($scope.dayEdit);
		$scope.dayEdit = null;
	};
	$scope.cancelDayEdit = function(){
		$scope.dayEdit = null;
	};
	$scope.deleteDay = function(){
		if (confirm("Are you sure you want to delete " + $scope.dayEdit.day + "?")) {
			Days.deleteDay($scope.dayEdit);
			$scope.dayEdit = null;
			$scope.unloadSessions();
		}
	};
	$scope.loadSessions = function(id){
		$scope.selectedDay = $scope.days[id];
		$scope.sessions = Days.days[id].sessions;
		$scope.clearSessions();
	};
	$scope.unloadSessions = function() {
		$scope.clearSessions();
		$scope.sessions = null;
	};

	//Sessions
	$scope.selectedSession = null;
	$scope.sessionEdit = null;
	$scope.sessionError = "";
	var validateSession = function(session) {
		if (!session.name || session.name === ''){
			$scope.sessionError = "Please add a Session Name";
			return false;
		} else if (!session.time || session.time === '') {
			$scope.sessionError = "Please add a Session Time";
			return false;
		} else {
			$scope.sessionError = "";		
			return true;
		}
	}
	$scope.addSession = function() {
		session = {time: $scope.newSessionTime, name: $scope.newSessionName, events:[]};
		if( !validateSession(session)) {return;}

		Days.createSession($scope.selectedDay, session)

		$scope.newSessionName = '';
		$scope.newSessionTime = '';
	};
	$scope.editSession = function(session){
		$scope.sessionEdit = angular.copy(session);
	};
	$scope.updateSession = function(){
		if (!validateSession($scope.sessionEdit)){return;}

		Days.updateSession($scope.selectedDay, $scope.sessionEdit)
		$scope.sessionEdit = null;
	};
	$scope.cancelSessionEdit = function(){
		$scope.sessionEdit = null;
	};
	$scope.deleteSession = function(){
		if(confirm("Are you sure you want to delete " + $scope.sessionEdit.name +"?")){
			Days.deleteSession($scope.selectedDay, $scope.sessionEdit);
			$scope.sessionEdit = null;
			$scope.unloadEvents();
		}
	};
	$scope.loadEvents = function(id){
		index = Days.days.indexOf($scope.selectedDay);
		$scope.selectedSession = $scope.days[index].sessions[id];
		$scope.events = Days.days[index].sessions[id].events;
		$scope.clearEvents();
	};
	$scope.unloadEvents = function() {
		$scope.clearSessions();
	};
	$scope.clearSessions = function(){
		$scope.selectedSession = null;
		$scope.events = null;
		$scope.clearEvents();
	};

	// -----------Events--------------------------
	$scope.selectedEvent = null;
	$scope.eventEdit = null;
	$scope.newEvent = null;
	$scope.showPresenters = false;
	$scope.showFacilitators = false;
	$scope.newEventPresenters = [];
	$scope.newEventFacilitators = [];
	
	var validatePresenterOrFacilitator = function(pof){
		if (!pof.name || pof.name === ''){
			$scope.formError = "Please add a name";
			return false;
		} else if (!pof.school || pof.school === ''){
			$scope.formError = "Please add a school";
			return false;
		} else {
			$scope.formError = "";
			return true;
		}
	}
	//Presenters and Facilitators
	$scope.openPresenter = function(){
		$scope.showPresenters = !$scope.showPresenters;
		$scope.formError = "";
		$scope.showFacilitators = false;
	}
	$scope.openFacilitator = function() {
		$scope.showFacilitators = !$scope.showFacilitators;
		$scope.formError = "";
		$scope.showPresenters = false;
	}
	$scope.addPresenter = function(event){
		presenter = {name: $scope.newPresenterName, school: $scope.newPresenterSchool};
		if (!validatePresenterOrFacilitator(presenter)) {return;}

		event.presenters.push(presenter);
		$scope.newPresenterName = '';
		$scope.newPresenterSchool = '';
		$scope.showPresenters = false;
	}
	$scope.addFacilitator = function(event){
		facilitator = {name: $scope.newFacilitatorName, school: $scope.newFacilitatorSchool}
		if (!validatePresenterOrFacilitator(facilitator)){return;}

		event.facilitators.push(facilitator);
		$scope.newFacilitatorName = '';
		$scope.newFacilitatorSchool = '';
		$scope.showFacilitators = false;
	}
	$scope.removePresenter = function(event, presenter){
		event.presenters.splice(event.presenters.indexOf(presenter), 1);
	}
	$scope.removeFacilitator = function(event, facilitator){
		event.facilitators.splice(event.facilitators.indexOf(facilitator), 1);
	}

	//EVENTS
	$scope.eventError = "";
	var validateEvent = function(event){
		if (!event.title || event.title === ''){
			$scope.eventError = "Please add a title";
			return false;
		} else if (!event.location || event.location === ''){
			$scope.eventError = "Please add a location";
			return false;
		} else {
			$scope.eventError = "";
			$scope.formError = "";
			$scope.newPresenterName = '';
			$scope.newPresenterSchool = '';
			$scope.newFacilitatorName = '';
			$scope.newFacilitatorSchool = '';
			return true;
		}
	}
	$scope.openEventAdder = function(){
		$scope.eventEdit = null;
		$scope.selectedEvent = null;
		$scope.newEvent = {presenters: [], facilitators: []};
	}
	$scope.addEvent = function() {
		if (!validateEvent($scope.newEvent)){return;}

		if(!$scope.newEvent.sid) {
			$scope.newEvent.sid = null;
		}

		if(!$scope.newEvent.description) {
			$scope.newEvent.description = null;
		}
		
		if(!$scope.newEvent.sponser){
			$scope.newEvent.sponser = null;
		}
		//Reset the error if the request goes through
		$scope.eventError = "";

		Days.createEvent($scope.selectedDay, $scope.selectedSession, $scope.newEvent);
		
		$scope.newEvent = null;
	};
	$scope.showEvent = function(event) {
		$scope.selectedEvent = event;
		$scope.eventEdit = null;
		$scope.newEvent = null;

	};
	$scope.editEvent = function(event){
		$scope.eventEdit = angular.copy(event);
		$scope.newEvent = null;
	};
	$scope.updateEvent = function(){
		if (!validateEvent($scope.eventEdit)){return;}
		
		Days.updateEvent($scope.selectedDay, $scope.selectedSession, $scope.eventEdit);
		$scope.eventEdit = null;
	};
	$scope.cancelEventEdit = function(){
		$scope.eventEdit = null;
	};
	$scope.deleteEvent = function(){
		if(confirm("Are you sure you want to delete " + $scope.eventEdit.title +"?")){
			Days.deleteEvent($scope.selectedDay, $scope.selectedSession, $scope.eventEdit);
			$scope.clearEvents();
		}
	};
	$scope.clearEvents = function(){
		$scope.eventEdit = null;
		$scope.selectedEvent = null;
		$scope.newEvent = null;
	};
});