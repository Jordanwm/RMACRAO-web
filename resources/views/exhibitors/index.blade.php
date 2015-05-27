@extends('app')

@section('content')

<div class="text-right">
	<a class="btn btn-default" href="{{route('exhibitors.create')}}">
		Add New Exhibitor
	</a>
</div>
<table class="table" ng-app="exhibitorApp" ng-controller="IndexCtrl">
	<thead>
		<tr>
			<th class="col-md-2">Name</th>
			<th class="col-md-2">Address</th>
			<th class="col-md-2">City</th>
			<th class="col-md-1">State</th>
			<th class="col-md-1">Zip</th>
			<th class="col-md-2">modify</th>
		</tr>
	</thead>
	<tbody>
		@foreach( $exhibitors as $exhibitor )
			<tr>
				<td>{{$exhibitor->name}}</td>
				<td>{{$exhibitor->address}}</td>
				<td>{{$exhibitor->city}}</td>
				<td>{{$exhibitor->state}}</td>
				<td>{{$exhibitor->zip}}</td>
				<td>
					<a href="{{route('exhibitors.edit', $exhibitor->id)}}"><span class="glyphicon glyphicon-edit"></span></a>
					&nbsp;|&nbsp;
					<a><span ng-click='delete(<?php echo json_encode($exhibitor); ?>)' class="glyphicon glyphicon-trash"></span></a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

@endsection

@section('scripts')

<script src="/js/angular-min-1.3.15.js"></script>
<script src="/js/exhibitorApp.js"></script>

@endsection