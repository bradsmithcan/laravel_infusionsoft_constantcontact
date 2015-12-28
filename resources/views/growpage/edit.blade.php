@extends('layouts.live_preview_master')

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

    {!! Form::open(['method' => 'PATCH', 'route' => ['growpage.update', $growPage['id']], 'files' => true, 'class' => 'inline-block']) !!}
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
            <h2 class="StepTitle">Step 1 Content</h2>
            <ul type="disk">
                <!-- Type -->
                <div class="form-group">
                    {!! Form::label('type', 'Type *', ['class' => 'col-sm-12 control-label page-label']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            {!! Form::select('type',['0' => 'Form Opt-In','1' => 'Button'], $growPage['type'], [ 'class' => 'type form-control']) !!}
                        </div>
                    </div>
                </div>
                <!-- Email Service -->
                <div id="email_section" style="@if(old('type') == '0') display: block; @elseif($growPage['type']== '0') display: block; @else display: none; @endif"  class="form-group">
                    {!! Form::label('api', 'Email Service *', ['class' => 'col-sm-12 control-label page-label']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            {!! Form::select('api', $services, $growPage['api'], ['class' => 'form-control']) !!}
                            <span class="help-block option-label-new">Choose what email service/list you would like to connect to for new subscriptions.</span>
                        </div>
                    </div>
                </div>
                <!-- Button Section -->
                <div id="button_section">
                    <!-- Button Text -->
                    <div class="form-group">
                        {!! Form::label('btntxt', 'Button Text', ['class' => 'col-sm-12 control-label page-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::text('btntxt', $growPage['btntxt'], ['placeholder' => 'Your Button Text', 'class' => 'btntxt form-control']) !!}
                                <span class="help-block option-label-new">Type in the text to be placed on your button here.</span>
                            </div>
                        </div>
                    </div>
                    <!-- Button Text Color -->
                    <div class="form-group">
                        {!! Form::label('btntxt_color', 'Button Text Color', ['class' => 'col-sm-12 control-label page-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="input-group btntxt_color">
                                    {!! Form::text('btntxt_color', $growPage['btntxt_color'], ['placeholder' => 'Your Button Text Color', 'class' => 'form-control colpick']) !!}
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Button URL -->
                    <div class="form-group">
                        {!! Form::label('btnurl', 'Button URL', ['class' => 'col-sm-12 control-label page-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::url('btnurl', $growPage['btnurl'], ['placeholder' => 'http://pageurl.com', 'class' => 'btnurl form-control', 'id' => 'btnurl']) !!}
                                <span class="help-block option-label-new">Type in the URL that the button will link to here.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
        </div>
        <div id="step-2">
            <h2 class="StepTitle">Step 2 Content</h2>
            <!-- Seconds to wait -->
            <div class="form-group">
                {!! Form::label('second', 'Seconds to wait ', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <input type="number" min="1" max="999" name="second" class="form-control" value="@if(old('second')){!!old('second')!!}@elseif(isset($growPage['second'])){!!$growPage['second']!!}@endif">
                    </div>
                </div>
            </div>

            <!-- Page URL -->
            <div class="form-group">
                {!! Form::label('page_url', 'Page URL *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::url('page_url', $growPage['page_url'], ['placeholder' => 'http://pageurl.com', 'class' => 'p_url  form-control']) !!}
                        <span class="help-block option-label-new">Please format your URL like this: http://mainurl.com</span>
                    </div>
                </div>
            </div>
            <!-- Domain -->
            <div class="form-group">
                {!! Form::label('domain', 'Domain *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::select('domain', [url('/') => url('/')], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <!-- URL Path -->
            <div class="form-group">
                {!! Form::label('url_path', 'URL Path', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('url_path', $growPage['url_path'], ['placeholder' => 'URL Path *', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div id="step-3">
            <h2 class="StepTitle">Step 3 Content</h2>
            <!-- Slide Down Title -->
            <div class="form-group">
                {!! Form::label('title', 'Slide Down Title *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('title', $growPage['title'], ['placeholder' => 'Your short catch-phrase to be placed here!', 'class' => 'cont_title  form-control']) !!}
                        <span class="help-block option-label-new">Type in your text to appear on the slide down here.</span>
                    </div>
                </div>
            </div>
            <!-- Title Color -->
            <div class="form-group">
                {!! Form::label('title_color', 'Title Color', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group title_color">
                            {!! Form::text('title_color', $growPage['title_color'], ['placeholder' => 'Your Title Color', 'class' => 'form-control colpick']) !!}
                            <span class="input-group-addon"><i></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slide Down Description -->
            <div class="form-group">
                {!! Form::label('descrip', 'Slide Down Description *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::textarea('descrip', $growPage['descrip'], ['rows' => '4', 'placeholder' => 'Place your paragraph/description to appear below the your title/header here.', 'class' => 'form-control cont_desc']) !!}
                        <span class="help-block option-label-new">Type in your description to appear under your title here.</span>
                    </div>
                </div>
            </div>
            <!-- Description Color -->
            <div class="form-group">
                {!! Form::label('descrip_color', 'Description Color', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group descrip_color">
                            {!! Form::text('descrip_color', $growPage['descrip_color'], ['placeholder' => 'Description Color', 'class' => 'form-control colpick']) !!}
                            <span class="input-group-addon"><i></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="step-4">
            <h2 class="StepTitle">Step 4 Content</h2>
            <!-- Slide Down Background -->
            <div class="form-group">
                {!! Form::label('bg', 'Slide Down Background *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <ul>
                            @foreach($backgrounds as $key => $background)
                                <li>
                                    <input type="radio" name="bg" class="bg" value="{!! $background['name'] !!}"  @if($growPage['bg'] == $background["name"] || old('bg') == $background["name"])  checked="checked" @endif>
                                    <a href="{!! asset('/images/backgrounds/'.$background["name"]) !!}" target="_blank">
                                        Option {!! $key+1 !!}
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
                {!! Form::label('upload_path', 'Image', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="growPage-upload-dragdrop" style="vertical-align:top;">
                            <div class="growPage-file-upload" style="position: relative; overflow: hidden; cursor: default;">Upload
                                {!! Form::file('file', ['class' => 'create-grow-page-input',  'id' => 'fileupload']) !!}
                                @if($growPage['upload_path'])
                                    {!! Form::hidden('image', $growPage['upload_path'], ['class' => 'create-grow-page-input', 'id' => 'img_hidden']) !!}
                                @else
                                    {!! Form::hidden('image', '', ['class' => 'create-grow-page-input', 'id' => 'img_hidden']) !!}
                                @endif
                            </div>
                            <span><b>Drag &amp; Drop Files</b></span>
                        </div>
                    </div>
                </div>
                <input type="button" value="Remove Image" id="remove_image" class="btn btn-default" />
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection

@include('growpage.live_preview')



