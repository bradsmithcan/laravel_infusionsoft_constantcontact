@extends('layouts.master')

@section('title', 'Dashboard')

@section('sidebar')

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 colxs-12">
                    <h4> Create New Profile </h4>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {!! Form::open(array('url' => 'profile', 'files' => true)) !!}
                    <div class="form-group">
                        <div class="col-xs-12">
                            {!! Form::label('title', 'Display Name') !!}
                        </div>
                        <div class="col-xs-12">
                            {!! Form::text('title', '', ['placeholder' => 'Profile Display Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            {!! Form::label('url', 'Display URL', ['class' => 'text-align-left']) !!}
                        </div>
                        <div class="col-xs-12" id="url_section">
                            {!! Form::text('url', '', ['placeholder' => 'http://usergrow.com/me', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            {!! Form::label("image",'Profile Image', ['class' => 'text-align-left']) !!}
                        </div>
                        <div class="col-xs-12">
                            {!! Form::file('image', '', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 text-right">
                            {!! Form::submit('Create', ['class' => 'btn btn-theme']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("#add_url").click(function(){
            $("#url_section").append('<input placeholder="http://yourtargeturl.com" class="form-control" name="redirect_url[]" type="url" value="">');
        });
    </script>


@endsection