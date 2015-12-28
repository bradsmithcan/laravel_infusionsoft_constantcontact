@extends('layouts.master')

@section('content')
	<h1>Domains Management </h1>
	<a href="{{url('admin/domain/create')}}" class="btn btn-success">Create Domain</a>
	<hr>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr class="bg-info">
				<th>ID</th>
				<th>Name</th>
				<th>Status</th>
				<th colspan="6">Actions</th>
			</tr>
		</thead>
		<tfoot>
			<tr class="bg-info">
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Status</th>
				<th colspan="6">Actions</th>
			</tr>
		</tfoot>
		<tbody>
		@foreach ($domains as $perDomain)
			<tr>
				<td>{{ $perDomain->id }}</td>
				<td>{{ $perDomain->name }}</td>
				<td>{{ $perDomain->status }}</td>
				<td><a href="{{route('admin.domain.edit',$perDomain->id)}}" class="btn btn-warning">Edit</a></td>
				<td>
					{!! Form::open(['method' => 'DELETE', 'route'=>['admin.domain.destroy', $perDomain->id]]) !!}
					{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
					{!! Form::close() !!}
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@endsection