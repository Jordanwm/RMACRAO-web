angular.module('app.services',[])

.filter('newlines', function(text){
	return function(text) {
		if (!text)
			return;
        return text.replace(/\n/g, '<br/>');
    };
})

.filter('noHtml', function(){
	return function(text) {
		if (!text)
			return;
        return text
                .replace(/&/g, '&amp;')
                .replace(/>/g, '&gt;')
                .replace(/</g, '&lt;');
    };
})

.factory('Days', function($http,CSRF_TOKEN){
	var o = {};
	o.days = [];
	o.get = function(){
		return $http.get('/api/sessions').success(function(data){
			angular.copy(data, o.days);
		});	
	};
	//Days
	o.createDay = function(day){
		$http.post('/sessions/', day).success(function(data){
			var newDay = data;
			newDay.sessions = [];

			o.days.push(newDay);
		});
	};
	o.updateDay = function(day){
		$http.put('/sessions/' + day.id, day).success(function(data){
			o.days.forEach(function(d) {
				if (d.id == data.id) {
					d.day = data.day;
				}
			});
		});
	};
	o.deleteDay = function(day){
		$http.delete('/sessions/' + day.id).success(function(data){
			o.days.forEach(function(d, index) {
				if (d.id == data.id) {
					o.days.splice(index, 1);
				}
			});
		});
	};
	
	//Sessions
	o.createSession = function(day, session){
		$http.post('/sessions/' + day.id + '/sessions/', session).success(function(data){
			var newSession = data;
			newSession.events = [];

			index = o.days.indexOf(day);
			o.days[index].sessions.push(newSession);
		});
	};
	o.updateSession = function(day, sessionEdit){
		$http.put('/sessions/' + day.id + '/sessions/' + sessionEdit.id, sessionEdit).success(function(data){
			index = o.days.indexOf(day);
			o.days[index].sessions.forEach(function(session){
				if (session.id == data.id) {
					session.time = data.time;
					session.name = data.name;
				}
			});
		});
	};
	o.deleteSession = function(day, session){
		$http.delete('/sessions/' + day.id + '/sessions/' + session.id, session).success(function(data){
			dayI = o.days.indexOf(day);
			o.days[dayI].sessions.forEach(function(session, index){
				if (session.id == data.id) {
					o.days[dayI].sessions.splice(index, 1);
				}
			});
		});
	};

	//Events
	o.createEvent = function(day, session, event){
		$http.post('/sessions/' + day.id + '/sessions/' + session.id + '/events', event).success(function(data){
			dayI = o.days.indexOf(day);
			sessionI = o.days[dayI].sessions.indexOf(session);

			o.days[dayI].sessions[sessionI].events.push(data);
			
		});
	};
	o.updateEvent = function(day, session, event){
		$http.put('/sessions/' + day.id + '/sessions/' + session.id +'/events/' + event.id, event).success(function(data){
			dayI = o.days.indexOf(day);
			sessionI = o.days[dayI].sessions.indexOf(session);
			
			o.days[dayI].sessions[sessionI].events.forEach(function(e){
				if (e.id == data.id) {
					e.title = data.title;
					e.sid = data.sid;
					e.description = data.description;
					e.sponser = data.sponser;
					e.presenters = data.presenters;
					e.facilitators = data.facilitators;
					e.location = data.location;
				}
			});
		});
	};
	o.deleteEvent = function(day, session, event){
		$http.delete('/sessions/' + day.id + '/sessions/' + session.id + '/events/' + event.id, event).success(function(data){
			dayI = o.days.indexOf(day);
			sessionI = o.days[dayI].sessions.indexOf(session);
			
			o.days[dayI].sessions[sessionI].events.forEach(function(e, index){
				if (e.id == data.id) {
					o.days[dayI].sessions[sessionI].events.splice(index, 1);
				}
			});
		});
	};
	return o;
});