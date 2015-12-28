@extends('layouts.master')

@section('content')
	<div class="row">
		<h1>Update Domain</h1>
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		{!! Form::model($domain,['method' => 'PATCH','route'=>['admin.domain.update',$domain->id]]) !!}
		<div class="form-group">
			{!! Form::label('Name', 'Name:') !!}
			{!! Form::text('name',$domain->name,['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			<label class="control-label">Type</label>
			<select name="status" class="form-control">
				@foreach($types as $key=>$r)
					<option  value="{!! $key !!}" @if($key == $domain->id) selected @endif> {!! $r !!}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			{!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
		</div>
		{!! Form::close() !!}
	</div>
@endsection
