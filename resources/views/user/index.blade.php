@extends('layouts.master')

@section('content')
	<h1>Users </h1>
	<a href="{{url('admin/user/create')}}" class="btn btn-success">Create User</a>
	<hr>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr class="bg-info">
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
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
		@foreach ($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td>@if($user->archive == 1) Suspended @elseif($user->activation == 1) Active @elseif($user->activation == 0) Not Active @endif</td>
				<td><a href="{{url('admin/user',$user->id)}}" class="btn btn-primary">Read</a></td>
				@if($user->archive == 1 && $user->activation == 0)
					<td><a href="{{url('admin/user/unsuspend',$user->id)}}" class="btn btn-primary">Unsuspend</a></td>
				@else
					<td><a href="{{url('admin/user/suspend',$user->id)}}" class="btn btn-danger">Suspend</a></td>
				@endif
				<td><a href="{{url('admin/user/upgrade',$user->id)}}" class="btn btn-primary">Upgrade</a></td>
				<td><a href="{{url('admin/user/downgrade',$user->id)}}" class="btn btn-primary">Downgrade</a></td>

				<td><a href="{{route('admin.user.edit',$user->id)}}" class="btn btn-warning">Edit</a></td>
				<td>
					{!! Form::open(['method' => 'DELETE', 'route'=>['admin.user.destroy', $user->id]]) !!}
					{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
					{!! Form::close() !!}
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@endsection