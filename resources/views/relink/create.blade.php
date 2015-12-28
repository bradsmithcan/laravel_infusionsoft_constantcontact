@extends('layouts.master')

@section('title', 'Dashboard')

@section('sidebar')

@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => 'relink')) !!}

        <div class="form-group">
            <div class="col-xs-12">
                {!! Form::label('title', 'Link Title') !!}
            </div>
            <div class="col-xs-12">
                {!! Form::text('title', '', ['placeholder' => 'Reference Name', 'class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                {!! Form::label('redirect_url', 'Redirect URL', ['class' => 'text-align-left']) !!}
            </div>
            <div class="col-xs-12" id="url_section">
                {!! Form::url('redirect_url', '', ['placeholder' => 'http://yourtargeturl.com','class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                {!! Form::label('domain', 'Domain', ['class' => 'text-align-left']) !!}
            </div>
            <div class="col-xs-12" id="url_section">
                {!! Form::select('domain', [url('/') => url('/')], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                {!! Form::label('url_path', 'URL Path', ['class' => 'text-align-left']) !!}
            </div>
            <div class="col-xs-12" id="url_section">
                {!! Form::text('url_path', '', ['placeholder' => 'URL Path', 'class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                {!! Form::label('code', 'Retargeting Pixel/Code', ['class' => 'text-align-left']) !!}
            </div>
            <div class="col-xs-12">
                {!! Form::textarea('code', '', ['placeholder' => 'Reference Name', 'rows' => '5','class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 text-right">
                {!! Form::submit('Create', ['class' => 'btn btn-default']) !!}
            </div>
        </div>

    {!! Form::close() !!}

@endsection
