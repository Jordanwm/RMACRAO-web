<div ng-app="exhibitorApp" ng-controller="MainCtrl">
	<div class="alert alert-danger" ng-show="err">
		<button type="button" class="close" ng-click="hideAlert()"><span >&times;</span></button>
		<p ng-bind="err"></p>
	</div>
	<div class="panel panel-primary">
		@if ($view == 'edit')
			<div class="panel-heading"><strong>Edit {{$exhibitor->name}}</strong></div>
			<div class="panel-body">
				<form ng-submit="submitForm(exhibitor, staff, 'put')" ng-init='setExhibitor(<?php echo json_encode($exhibitor) ?>)'>
		@else
			<div class="panel-heading"><strong>Create a New Exhibitor</strong></div>
			<div class="panel-body">
				<form ng-submit="submitForm(exhibitor, staff, 'post')">
		@endif
				<div class="form-group">
					<div class="input-group">
						<p class="input-group-addon">Name</p>
						<input type="text" class="form-control" ng-model="exhibitor.name" placeholder="Company">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<div class="input-group">
								<p class="input-group-addon">Address</p>
								<input type="text" ng-model="exhibitor.address" class="form-control" placeholder="123 1st St.">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<div class="input-group">
								<p class="input-group-addon">City</p>
								<input type="text" ng-model="exhibitor.city" class="form-control" placeholder="Somewhere">
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<p class="input-group-addon">State</p>
								<input type="text" ng-model="exhibitor.state" class="form-control" placeholder="CO">
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<p class="input-group-addon">Zip</p>
								<input type="text" ng-model="exhibitor.zip" class="form-control" placeholder="12345">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<p>Description:</p>
							<textarea cols="30" rows="10" ng-model="exhibitor.description" class="form-control" placeholder="Description..."></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<p>Staff Members: <span class="pull-right btn btn-primary btn-xs" data-toggle="modal" data-target="#staffForm" ng-click="addStaff()"><i class="glyphicon glyphicon-plus"></i></span></p>
						<ul class="list-group" ng-show="staff.length > 0">
							<li class="list-group-item" ng-repeat="s in staff">
								<span ng-bind="s.name + ', ' + s.title"></span>
								<div class="pull-right">
									<div class="btn btn-warning btn-xs" data-toggle="modal" data-target="#staffForm" ng-click="editStaff(s)"><i class="glyphicon glyphicon-edit"></i></div>
									&nbsp;
									<div class="btn btn-danger btn-xs" ng-click="removeStaff(s)"><i class="glyphicon glyphicon-trash"></i></div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					@if ($view == 'edit')
						{!! Form::Submit('Update', ['class' => 'btn btn-primary']) !!}
					@else
						{!! Form::Submit('Create', ['class' => 'btn btn-primary']) !!}
					@endif
					<a href="{{route('exhibitors.index')}}" class="btn btn-danger">Cancel</a>
				</div>
			</form>
		</div>
	</div>
	<div class="modal fade" id="staffForm" tabindex="-1" role="dialog">
		<div class="modal-dialog">
		    <div class="modal-content">
		    	<div class="modal-header">
		    		<button class="close" data-dismiss="modal"><span>&times;</span></button>
		    		<h4 class="modal-title" ng-bind="modalTitle"></h4>
		    	</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="input-group">
							<p class="input-group-addon">Name</p>
							<input type="text" class="form-control" ng-model="name" placeholder="John Doe">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<p class="input-group-addon">Title</p>
							<input type="text" class="form-control" ng-model="title" placeholder="Vice President">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<i type="button" class="btn btn-default" data-dismiss="modal">Close</i>
					<button class="btn btn-primary" ng-click="addMember({name: name, title: title})" ng-bind="modalSubmitBtn"></button>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection