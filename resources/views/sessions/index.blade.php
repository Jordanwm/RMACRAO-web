@extends('app')

@section('content')

<div ng-app="app">
	<ui-view></ui-view>
</div>

@endsection

@section('scripts')

<script src="/js/angular-min-1.3.15.js"></script>
<script src="/js/angular-ui-router-min-0.2.14.js"></script>
<script src="/js/angularApp.js"></script>
<script src="/js/controllers.js"></script>
<script src="/js/services.js"></script>
<script>
	angular.module('app').constant("CSRF_TOKEN", '{!! csrf_token() !!}');
</script>

@endsection