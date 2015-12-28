@extends('layouts.master')

@section('content')
	<div class="row">
		<h1>Create New Domain</h1>
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		{!! Form::open(['url' => 'admin/domain']) !!}
		<div class="form-group">
			{!! Form::label('name', 'Domain Name:') !!}
			{!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'http://trkn.co']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('type', 'Type:') !!}
			{!!  	Form::select('status', $types, old('status') , ['class'=>'form-control'])!!}
		</div>

		<div class="form-group">
			{!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
		</div>
		{!! Form::close() !!}
	</div>
@endsection
