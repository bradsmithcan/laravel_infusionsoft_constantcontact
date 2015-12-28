@extends('layouts.master')

@section('content')
<h1>User Show</h1>

<form class="form-horizontal">
    <div class="form-group">
        <label for="publisher" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="publisher" placeholder={!!$user->id!!} readonly>
        </div>
    </div>
    <div class="form-group">
        <label for="publisher" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="publisher" placeholder={!! $user->name !!} readonly>
        </div>
    </div>
    <div class="form-group">
        <label for="publisher" class="col-sm-2 control-label">First</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="publisher" placeholder={!!$user->first!!} readonly>
        </div>
    </div>
    <div class="form-group">
        <label for="publisher" class="col-sm-2 control-label">Last</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="publisher" placeholder={!!$user->last!!} readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="publisher" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="publisher" placeholder={!!$user->email!!} readonly>
        </div>
    </div>
    <div class="form-group">
        <label for="publisher" class="col-sm-2 control-label">Paid</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="publisher" placeholder={!!$user->paid!!} readonly>
        </div>
    </div>
    <div class="form-group">
        <label for="publisher" class="col-sm-2 control-label">Type</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="publisher" placeholder={!!$role->name!!} readonly>
        </div>
    </div>
    <div class="form-group">
        <label for="publisher" class="col-sm-2 control-label">Profile_count</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="publisher" placeholder={!!$user->profile_count!!} readonly>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <a href="{!! url('user')!!}" class="btn btn-primary">Back</a>
        </div>
    </div>
</form>
@endsection