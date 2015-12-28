@extends('layouts.master')

@section('title', 'Dashboard')

@section('sidebar')

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 colxs-12">
            <h4> Edit {{$profile->child_name}} Profile </h4>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::open(array('method' => 'put','url' => route('profile.update',array($profile->id)) , 'files' => true)) !!}

            <div class="form-group">
                <div class="col-xs-12">
                    {!! Form::label('title', 'Display Name') !!}
                </div>
                <div class="col-xs-12">
                    {!! Form::text('title', $profile->child_name, ['placeholder' => 'Profile Display Name', 'class' => 'form-control' ]) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    {!! Form::label('url', 'Display URL', ['class' => 'text-align-left']) !!}
                </div>
                <div class="col-xs-12" id="url_section">
                    {!! Form::text('url', $profile->child_home_url, ['placeholder' => 'http://usergrow.com/me', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    {!! Form::label("image",'Profile Image', ['class' => 'text-align-left']) !!}
                </div>
                <div class="col-xs-12">

                    <img src="/{{ $image_path.$profile->child_pic_resize }}" />
                    <br/><br/>
                    {!! Form::file('image', '', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 text-right">
                    {!! Form::submit('Update', ['class' => 'btn btn-theme']) !!}
                </div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection