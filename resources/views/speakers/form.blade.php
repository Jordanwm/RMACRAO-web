<div class="panel panel-primary">
	@if ($view == 'edit')
		<div class="panel-heading"><strong>Edit {{$speaker->name}}</strong></div>
		<div class="panel-body">
			{!! Form::model($speaker, ['action'=>['SpeakersController@update', $speaker->id], 'method'=>'put']) !!}
	@else
		<div class="panel-heading"><strong>Create a New Speaker</strong></div>
		<div class="panel-body">
			{!! Form::open(['route'=>'speakers.store']) !!}
	@endif
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="input-group">
							{!! Form::label('name', null,['class' => 'input-group-addon']) !!}
							{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'John Doe']) !!}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="input-group">
							{!! Form::label('session', null,['class' => 'input-group-addon']) !!}
							{!! Form::text('session', null, ['class'=>'form-control', 'placeholder'=>'Opening Session']) !!}
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<div class="input-group">
							{!! Form::label('day', null,['class' => 'input-group-addon']) !!}
							{!! Form::text('day', null, ['class'=>'form-control', 'placeholder'=>'Wednesday, July 17th']) !!}
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="input-group">
							{!! Form::label('time', null,['class' => 'input-group-addon']) !!}
							{!! Form::text('time', null, ['class'=>'form-control', 'placeholder'=>'12:00 - 2:30']) !!}
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="input-group">
							{!! Form::label('location', null,['class' => 'input-group-addon']) !!}
							{!! Form::text('location', null, ['class'=>'form-control', 'placeholder'=>'Grand Ballroom']) !!}
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					{!! Form::label('title', null,['class' => 'input-group-addon']) !!}
					{!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>'The Case for Interdivisional Collaboration: A Sudden Transition from Best Practice to Necessity']) !!}
				</div>
			</div>
			<div class="form-group">
				@if ($view == 'edit')
					{!! Form::Submit('Update', ['class' => 'btn btn-primary']) !!}
				@else
					{!! Form::Submit('Create', ['class' => 'btn btn-primary']) !!}
				@endif
				<a href="{{route('speakers.index')}}" class="btn btn-danger">Cancel</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>

@endsection