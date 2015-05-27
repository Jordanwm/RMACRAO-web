@extends('app')

@section('content')

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-danger text-center">
			<div class="panel-heading"><strong>Delete {{$speaker->name}}</strong></div>
			<div class="panel-body">
				{!! Form::open(['action'=>['SpeakersController@destroy', $speaker->id], 'method'=>'delete']) !!}
					<h3 class="text-danger">Are you sure?</h3>
					<div class="form-group">
						{!! Form::Submit('Delete', ['class' => 'btn btn-success']) !!}
						<a href="{{route('speakers.index')}}" class="btn btn-danger">Cancel</a>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection