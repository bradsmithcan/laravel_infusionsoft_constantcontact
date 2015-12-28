@extends('layouts.live_preview_master')

@section('content')

    {!! Form::open(array('url' => 'growpage', 'files' => true)) !!}

    <div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepDesc">
                       Step 1
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepDesc">
                       Step 2
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-3">
                    <span class="stepDesc">
                       Step 3
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-4">
                    <span class="stepDesc">
                       Step 4
                    </span>
                </a>
            </li>
        </ul>

        <div id="step-1">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Step 1 Content</h3>
                </div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <ul type="disk">
                        <!-- Type -->
                        <div class="form-group">
                            {!! Form::label('type', 'Type *', ['class' => 'col-sm-12 control-label page-label row']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::select('type',['0' => 'Form Opt-In','1' => 'Button'], null, [ 'class' => 'type form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <!-- Email Service -->
                        <div id="email_section" class="form-group" @if(old('type') == '1')style="display: none"@endif>
                            {!! Form::label('api', 'Email Service *', ['class' => 'col-sm-12 control-label page-label row']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::select('api', $services, null, ['class' => 'form-control']) !!}
                                    <span class="help-block option-label-new">Choose what email service/list you would like to connect to for new subscriptions.</span>
                                </div>
                            </div>
                        </div>
                        <!-- Button Section -->
                        <div id="button_section" >
                            <!-- Button Text -->
                            <div class="form-group">
                                {!! Form::label('btntxt', 'Button Text', ['class' => 'col-xs-12 control-label page-label row']) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::text('btntxt', '', ['placeholder' => 'Your Button Text', 'class' => 'btntxt form-control']) !!}
                                        <span class="help-block option-label-new">Type in the text to be placed on your button here.</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Button Text Color -->
                            <div class="form-group">
                                {!! Form::label('btntxt_color', 'Button Text Color', ['class' => 'col-xs-12 control-label page-label row']) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="input-group btntxt_color">
                                            {!! Form::text('btntxt_color', '', ['placeholder' => 'Your Button Text Color', 'class' => 'form-control colpick']) !!}
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Button URL -->
                            <div class="form-group">
                                {!! Form::label('btnurl', 'Button URL', ['class' => 'col-sm-12 control-label page-label row']) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::url('btnurl', '', ['placeholder' => 'http://pageurl.com', 'class' => 'form-control']) !!}
                                        <span class="help-block option-label-new">Type in the URL that the button will link to here.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div id="step-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Step 2 Content</h3>
                </div>
                <div class="panel-body">

            <div class="form-group">
                {!! Form::label('second', 'Seconds to wait ', ['class' => 'col-sm-12 control-label page-label row']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <input type="number" min="1" max="999" name="second" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Page URL -->
            <div class="form-group">
                {!! Form::label('page_url', 'Page URL *', ['class' => 'col-sm-12 control-label page-label row']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::url('page_url', '', ['placeholder' => 'http://pageurl.com', 'class' => 'p_url form-control']) !!}
                        <span class="help-block option-label-new">Please format your URL like this: http://mainurl.com</span>
                    </div>
                </div>
            </div>
            <!-- Domain -->
            <div class="form-group">
                {!! Form::label('domain', 'Domain *', ['class' => 'col-sm-12 control-label page-label row']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::select('domain', [url('/') => url('/')], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <!-- URL Path -->
            <div class="form-group">
                {!! Form::label('url_path', 'URL Path', ['class' => 'col-sm-12 control-label page-label row']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('url_path', '', ['placeholder' => 'URL Path *', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
        <div id="step-3">
                <div class="panel panel-default" style="min-height: 500px">
                    <div class="panel-heading">
                        <h3 class="panel-title">Step 3 Content</h3>
                    </div>
                    <div class="panel-body">

            <!-- Slide Down Title -->
            <div class="form-group">
                {!! Form::label('title', 'Slide Down Title *', ['class' => 'col-xs-12 control-label page-label row']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('title', '', ['placeholder' => 'Your short catch-phrase to be placed here!', 'class' => 'cont_title form-control']) !!}
                        <span class="help-block option-label-new">Type in your text to appear on the slide down here.</span>
                    </div>
                </div>
            </div>
            <!-- Title Color -->
            <div class="form-group">
                {!! Form::label('title_color', 'Title Color', ['class' => 'col-sm-12 control-label page-label row']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group title_color">
                            {!! Form::text('title_color', '', ['placeholder' => 'Your Title Color', 'class' => 'col_title form-control colpick']) !!}
                            <span class="input-group-addon "><i></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slide Down Description -->
            <div class="form-group">
                {!! Form::label('descrip', 'Slide Down Description *', ['class' => 'col-sm-12 control-label page-label row']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::textarea('descrip', '', ['rows' => '4', 'placeholder' => 'Place your paragraph/description to appear below the your title/header here.', 'class' => 'cont_desc form-control']) !!}
                        <span class="help-block option-label-new">Type in your description to appear under your title here.</span>
                    </div>
                </div>
            </div>
            <!-- Description Color -->
            <div class="form-group">
                {!! Form::label('descrip_color', 'Description Color', ['class' => 'col-sm-12 control-label page-label row']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group descrip_color">
                            {!! Form::text('descrip_color', '', ['placeholder' => 'Description Color', 'class' => 'form-control colpick']) !!}
                            <span class="input-group-addon"><i></i></span>
                        </div>
                    </div>
                </div>
            </div>
                    </div>
                </div>

        </div>
        <div id="step-4">
            <div class="panel panel-default" style="min-height: 500px">
                <div class="panel-heading">
                    <h3 class="panel-title">Step 4 Content</h3>
                </div>
                <div class="panel-body">

                <!-- Slide Down Background -->
            <div class="form-group">
                {!! Form::label('bg', 'Slide Down Background *', ['class' => 'col-sm-12 control-label page-label row']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <ul>
                            @foreach($backgrounds as $key => $background)
                                <li>
                                    <input type="radio" name="bg" class="bg" value="{!! $background['name'] !!}" @if(old('bg')) @if(old('bg')==$background['name']) checked="checked" @endif @elseif($key==0) checked="checked" @endif>
                                    <a href="{!! asset('/images/backgrounds/'.$background["name"]) !!}" target="_blank">
                                        Option {!! $key+1 !!} @if($key==0)(Default)@endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <span class="help-block option-label-new">Choose the background of your slide down. The image <u>will be made lighter</u> on your slide down.</span>
                    </div>
                </div>
            </div>
            <!-- Upload Image -->
            <div class="form-group" id="full_wid_img">
                {!! Form::label('upload_path', 'Image', ['class' => 'col-sm-2 control-label page-label row']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <span id="user_uploader_div">
                            <div class="growPage-upload-dragdrop" style="vertical-align:top;">
                                <div class="growPage-file-upload" style="position: relative; overflow: hidden; cursor: default;">Upload
                                    {!! Form::file('file',['class' => 'create-grow-page-input', 'id' => 'fileupload']) !!}
                                    {!! Form::hidden('image', '', ['class' => 'create-grow-page-input', 'id' => 'img_hidden']) !!}
                                </div>
                                <span><b>Drag &amp; Drop Files</b></span>
                            </div>
                        </span>
                    </div>
                </div>
                <input type="button" value="Remove Image" id="remove_image" class="btn btn-default" />
            </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End SmartWizard Content -->
    {!! Form::close() !!}

@endsection

@include('growpage.live_preview')