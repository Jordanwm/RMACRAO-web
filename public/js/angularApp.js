var app = angular.module('app', ['ui.router', 'app.controllers', 'app.services'])

.config(function($stateProvider, $urlRouterProvider){
	$urlRouterProvider.otherwise('/');

	$stateProvider
		.state('home', {
			url: '/',
			templateUrl: '/angular-templates/home.html',
			controller: 'MainCtrl',
			resolve: {
				days: function(Days){
					return Days.get();
				}
			}
		});
});