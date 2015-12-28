@extends('layouts.master')

@section('content')
	<div class="row">
		<h1>Update User</h1>
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		{!! Form::model($user,['method' => 'PATCH','route'=>['admin.user.update',$user->id]]) !!}
		<div class="form-group">
			{!! Form::label('Name', 'Name:') !!}
			{!! Form::text('name',$user->name,['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('First', 'First:') !!}
			{!! Form::text('first',$user->first,['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Last', 'Last:') !!}
			{!! Form::text('last',$user->last,['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Email', 'Email:') !!}
			{!! Form::email('email',$user->email,['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Paid', 'Paid:') !!}
			{!! Form::text('paid',$user->paid,['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			<label class="control-label">Type</label>
			<select name="type" class="form-control">
				@foreach($roles as $r)
					<option  value="{!! $r->id !!}" @if($r->id == $role->id) selected @endif> {!! $r->name !!}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			{!! Form::label('Profile_count', 'Profile_count:') !!}
			{!! Form::text('profile_count',$user->profile_count,['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
		</div>
		{!! Form::close() !!}

	</div>
@endsection
