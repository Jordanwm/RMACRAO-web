@extends('app')

@section('content')

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				{{$exhibitor->name}} 
				<a class="btn btn-default btn-xs pull-right" href="{{route('exhibitors.edit', $exhibitor->id)}}"><i class="glyphicon glyphicon-edit"></i></a>
			</div>
			<div class="panel-body">
				<h4>Staff</h4>
					<ul class="list-unstyled">
						@foreach($exhibitor->staff as $s)
							<li><h6>{{$s->name}}, {{$s->title}}</h6></li>
						@endforeach
					</ul>
				<h4>Description:</h4><h6 style="white-space:pre-wrap;">{{$exhibitor->description}}</h6>
				<h4>Address:</h4><h6>{{$exhibitor->address}}</h6><h6>{{$exhibitor->city}}, {{$exhibitor->state}} {{$exhibitor->zip}}</h5>
			</div>
		</div>
	</div>
</div>

@endsection