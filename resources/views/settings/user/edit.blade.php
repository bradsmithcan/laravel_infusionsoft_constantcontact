@extends('layouts.master')


@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2>My Account</h2>
            {!! Form::open(['method' => 'PATCH', 'action' => ['UserController@update', $user->id]]) !!}
                <div class="form-group">
                    {!! Form::label('firstName', 'First Name:') !!}
                    {!! Form::text('firstName', $contact['FirstName'], ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('secondName', 'Second Name:') !!}
                    {!! Form::text('secondName', $contact['LastName'], ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::email('email', $contact['Email'], ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
                </div>
            {!! Form::close() !!}
            @include('errors.list')
        </div>
    </div>
@stop
