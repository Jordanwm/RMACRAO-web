@extends('app')

@section('content')

<div class="text-right">
	<a class="btn btn-default" href="{{route('speakers.create')}}">
		Add New Speaker
	</a>
</div>
<table class="table">
	<thead>
		<tr>
			<th class="col-md-2">Name</th>
			<th class="col-md-2">Session</th>
			<th class="col-md-2">Day</th>
			<th class="col-md-1">Time</th>
			<th class="col-md-1">Location</th>
			<th class="col-md-3">Title</th>
			<th class="col-md-2">Modify</th>
		</tr>
	</thead>
	<tbody>
		@foreach( $speakers as $speaker )
			<tr>
				<td>{{$speaker->name}}</td>
				<td>{{$speaker->session}}</td>
				<td>{{$speaker->day}}</td>
				<td>{{$speaker->time}}</td>
				<td>{{$speaker->location}}</td>
				<td>{{$speaker->title}}</td>
				<td>
					<a href="{{route('speakers.edit', $speaker->id)}}"><span class="glyphicon glyphicon-edit"></span></a>
					&nbsp;|&nbsp;
					<a href="{{action('SpeakersController@delete', $speaker->id)}}"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

@endsection