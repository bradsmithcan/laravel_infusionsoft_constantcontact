@extends('layouts.master')

@section('title', 'Dashboard')

@section('sidebar')

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 colxs-12">
            <div class="card ">
                <div class="header">

                    <!-- will be used to show any messages -->
                    @if (Session::has('message'))
                        <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
                    @if(\Auth::user()->isNotChild())
                        <h4 class="title">
                            <a href="{!! route('profile.create') !!}" class="btn btn-success btn-fill btn-wd"> Add New Profile </a>
                        </h4>
                    @endif
                </div>
                <div class="content">
                    <div class="row">
                            <div class="table-responsive">
                                @foreach($profile as $perProfile)
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="header">
                                                <h4 class="title">{!! $perProfile->child_name  !!}</h4>
                                                <p class="category">{!! $perProfile->child_home_url !!}</p>
                                            </div>
                                            <div class="content">
                                                <img src="{!! $image_path.$perProfile->child_pic_resize !!}" />
                                            </div>
                                            <div class="footer">
                                                <div class="legend">
                                                </div>
                                                <hr>
                                                <div class="stats">
                                                    <i class="fa fa-clock-o"></i> Created on {!! $perProfile->created_at !!}
                                                    <br/>
                                                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                                        <div class="col-lg-3 col-sm-3 col-md-4 col-xs-3">
                                                            <a class="btn btn-warning" href="{!! route('profile.edit',array($perProfile->id)) !!}"><i class="fa fa-edit"></i></a>
                                                        </div>
                                                        @if(\Auth::user()->isNotChild())
                                                            <div class="col-lg-3 col-sm-3 col-md-4 col-xs-3">
                                                                {!! Form::open(array('url' => 'profile/' . $perProfile->id)) !!}
                                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                                {!! Form::submit('Remove', array('class' => 'btn btn-warning')) !!}
                                                                {!! Form::close() !!}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection