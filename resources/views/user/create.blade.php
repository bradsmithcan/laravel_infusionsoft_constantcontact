@extends('layouts.master')

@section('content')
	<div class="row">
		<h1>Create user</h1>
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		{!! Form::open(['url' => 'admin/user']) !!}
		<div class="form-group">
			{!! Form::label('name', 'Name:') !!}
			{!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'name']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('first', 'First:') !!}
			{!! Form::text('first',null,['class'=>'form-control', 'placeholder'=>'first']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('last', 'Last:') !!}
			{!! Form::text('last',null,['class'=>'form-control', 'placeholder'=>'last']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('email', 'Email:') !!}
			{!! Form::email('email',null,['class'=>'form-control', 'placeholder'=>'email']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('type', 'Type:') !!}
			{!!  	Form::select('type', $roles, old('type') , ['class'=>'form-control'])!!}
		</div>

		<div class="form-group">
			{!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
		</div>
		{!! Form::close() !!}
	</div>
@endsection
