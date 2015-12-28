@extends('layouts.master_growBar')

@section('content')

    {!! Form::open(['method' => 'PATCH', 'route' => ['growbar.update', $growBar['id']], 'class' => 'inline-block']) !!}
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
                    {!! Form::label('type', 'GrowBar Type *', ['class' => 'col-sm-12 control-label page-label']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            Form Opt-In
                            {!! Form::radio('type', '0', $growBar['type'] == '0' ? true : false , ['class' => 'type']) !!}
                            Button
                            {!!  Form::radio('type', '1', $growBar['type'] == '1' ? true : false , ['class' => 'type'])  !!}
                        </div>
                    </div>
                </div>

                <!-- Email Service -->
                <div id="email_section" class="form-group" @if($growBar['type'] == '0') style="display: block" @elseif(old('type') == '1' || !old('type'))style="display: none"@endif>
                    {!! Form::label('api_id', 'Email Service *', ['class' => 'col-sm-12 control-label page-label']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            {!! Form::select('api_id', $services, $growBar['api_id'], ['class' => 'form-control']) !!}
                            <span class="help-block option-label-new">Choose what email service/list you would like to connect to for new subscriptions.</span>
                        </div>
                    </div>
                </div>
                <!-- Button Section -->
                <div>
                    <!-- Website URL -->
                    <div class="form-group">
                        {!! Form::label('website_url', 'Website URL', ['class' => 'col-xs-12 control-label page-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::url('website', $growBar['website'], ['placeholder' => 'Website URL', 'class' => 'form-control']) !!}
                                <span class="help-block option-label-new">Website URL where growbar will show.</span>
                            </div>
                        </div>
                    </div>
                    <!-- Call to action URL -->
                    <div class="form-group">
                        {!! Form::label('call_to_action_url', 'Call to action URL', ['class' => 'col-xs-12 control-label page-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::url('link_url', $growBar['link_url'], ['placeholder' => 'Call to action URL', 'class' => 'form-control']) !!}
                                <span class="help-block option-label-new">This is the web address that your button will link to.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Open link in new window -->
                    <div class="form-group">
                        {!! Form::label('open_link_in_new_window', 'Open link in new window *', ['class' => 'col-sm-12 control-label page-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                Yes
                                {!! Form::radio('openin', '1', $growBar['openin'] == '1' ? true : false) !!}
                                No
                                {!!  Form::radio('openin', '0', $growBar['openin'] == '0' ? true : false)  !!}
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
        </div>
        <div id="step-2">
            <h2 class="StepTitle">Step 2 Content</h2>
            <!-- Headline -->
            <div class="form-group">
                {!! Form::label('headline', 'Headline', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('headline', $growBar['headline'], ['placeholder' => 'Headline', 'class' => 'headline form-control']) !!}
                    </div>
                </div>
            </div>

            <!-- Link Text -->
            <div class="form-group">
                {!! Form::label('link_text', 'Link Text *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('link_text', $growBar['link_text'], ['placeholder' => 'Link Text', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <!-- Font Family -->
            <div class="form-group">
                {!! Form::label('font_family', 'Font Family *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::select('font_family', ['Open Sans'=>'Open Sans', 'Helvetica'=>'Helvetica', 'Arial'=>'Arial', 'Georgia'=>'Georgia', 'Sans-Serif'=>'Sans-Serif'], $growBar['font_family'], ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <!-- Background Color -->
            <div class="form-group">
                {!! Form::label('background_color', 'Background Color', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group background_color">
                            {!! Form::text('background_color',  old('background_color') ? old('background_color') : $growBar['background_color']  , ['placeholder' => 'Background Color', 'class' => ' form-control colpick']) !!}
                            <span class="input-group-addon"><i></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Text Color -->
            <div class="form-group">
                {!! Form::label('text_color', 'Text Color', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group text_color">
                            {!! Form::text('text_color',  old('text_color') ? old('text_color') : $growBar['text_color'] , ['placeholder' => 'Text Color', 'class' => ' form-control colpick']) !!}
                            <span class="input-group-addon"><i></i></span>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div id="step-3">
            <h2 class="StepTitle">Step 3 Content</h2>
            <!-- Button Color -->
            <div class="form-group">
                {!! Form::label('action_color', 'Button Color', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group action_color">
                            {!! Form::text('action_color', old('action_color') ? old('action_color') : $growBar['action_color'] , ['placeholder' => 'Button Color', 'class' => ' form-control colpick']) !!}
                            <span class="input-group-addon"><i></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button Text Color -->
            <div class="form-group">
                {!! Form::label('action_text_color', 'Button Text Color', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group action_text_color">
                            {!! Form::text('action_text_color', old('action_text_color') ? old('action_text_color') : $growBar['action_text_color'] , ['placeholder' => 'Button Text Color', 'class' => ' form-control colpick']) !!}
                            <span class="input-group-addon"><i></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Position -->
            <div class="form-group">
                {!! Form::label('position', 'Position *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::select('position', ['Top'=>'Top', 'Bottom'=>'Bottom'], old('position') ? old('position') : $growBar['position'] , ['class' => 'position form-control']) !!}
                    </div>
                </div>
            </div>
            <!-- Bar Size -->
            <div class="form-group">
                {!! Form::label('size', 'Bar Size *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::select('size', ['large'=>'Large - 50px height, 17px font', 'regular'=>'Regular - 30px height, 14px font'],  old('size') ? old('size') : $growBar['size'] , ['class' => 'size form-control']) !!}
                    </div>
                </div>
            </div>

        </div>
        <div id="step-4">
            <h2 class="StepTitle">Step 4 Content</h2>

            <!-- animate -->
            <div class="form-group">
                {!! Form::label('animate', 'Animate entry/exit *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        Yes
                        {!! Form::radio('animate', '1',  old('animate') == '1' ? true : ($growBar['animate'] == '1' ? true : false) ) !!}
                        No
                        {!!  Form::radio('animate', '0', old('animate') == '0' ? true : ($growBar['animate'] == '0' ? true : false) )  !!}
                    </div>
                </div>
            </div>
            <!-- Wiggle button -->
            <div class="form-group">
                {!! Form::label('wiggle', 'Wiggle button *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        Yes
                        {!! Form::radio('wiggle', '1', old('wiggle') == '1' ? true : ($growBar['wiggle'] == '1' ? true : false) , ['onclick'=> 'wigglebtn()']) !!}
                        No
                        {!!  Form::radio('wiggle', '0', old('wiggle') == '0' ? true : ($growBar['wiggle'] == '0' ? true : false) )  !!}
                    </div>
                </div>
            </div>
            <!-- Allow to hide bar -->
            <div class="form-group">
                {!! Form::label('hidebar', 'Allow to hide bar *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        Yes
                        {!! Form::radio('hidebar', '1', old('hidebar') == '1' ? true : ($growBar['hidebar'] == '1' ? true : false)) !!}
                        No
                        {!!  Form::radio('hidebar', '0', old('hidebar') == '0' ? true : ($growBar['hidebar'] == '0' ? true : false))  !!}
                    </div>
                </div>
            </div>
            <!-- Pushes page down -->
            <div class="form-group">
                {!! Form::label('push', 'Pushes page down *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        Yes
                        {!! Form::radio('push', '1',  old('push') == '1' ? true : ($growBar['push'] == '1' ? true : false)) !!}
                        No
                        {!!  Form::radio('push', '0',  old('push') == '0' ? true : ($growBar['push'] == '0' ? true : false))  !!}
                    </div>
                </div>
            </div>

            <!-- COUNTDOWN -->
            <div class="form-group">
                {!! Form::label('cd', 'COUNTDOWN', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group">
                            Yes
                            {!! Form::radio('cd', '1',  old('cd') == '1' ? true : ($growBar['cd'] == '1' ? true : false), ['class'=> 'cd']) !!}
                            No
                            {!! Form::radio('cd', '0',  old('cd') == '0' ? true : ($growBar['cd'] == '0' ? true : false), ['class'=> 'cd'])  !!}

                        </div>
                    </div>
                </div>
            </div>
            <div id="countDown"  {!!  old('cd') == '1' ? true : ($growBar['cd'] == '1' ? true : 'style="display: none;"') !!} >
                <!-- COUNTDOWN Background Color (optional) -->
                <div class="form-group">
                    {!! Form::label('cdbg', 'COUNTDOWN Background Color (optional)', ['class' => 'col-sm-12 control-label page-label']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group cdbg">
                                {!! Form::text('cdbg', old('cdbg') ? old('cdbg') : $growBar['cdbg'], ['placeholder' => 'COUNTDOWN Background Color (optional)', 'class' => 'form-control colpick']) !!}
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COUNTDOWN Text Color (optional) -->
                <div class="form-group">
                    {!! Form::label('cdtext', 'COUNTDOWN Text Color (optional)', ['class' => 'col-sm-12 control-label page-label']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group cdtext">
                                {!! Form::text('cdtext', old('cdtext') ? old('cdtext') : $growBar['cdtext'], ['placeholder' => 'COUNTDOWN Text Color (optional)', 'class' => 'form-control colpick']) !!}
                                <span class="input-group-addon "><i></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COUNTDOWN Lable Color (optional) -->
                <div class="form-group">
                    {!! Form::label('cdlc', 'COUNTDOWN Lable Color (optional)', ['class' => 'col-sm-12 control-label page-label']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group cdlc">
                                {!! Form::text('cdlc', old('cdlc') ? old('cdlc') : $growBar['cdlc'], ['placeholder' => 'COUNTDOWN Lable Color (optional)', 'class' => 'form-control colpick']) !!}
                                <span class="input-group-addon "><i></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End SmartWizard Content -->
    {!! Form::close() !!}

@endsection
