@extends('layouts.master_growBar')

@section('content')

    {!! Form::open(array('url' => 'growbar')) !!}
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
                            {!! Form::radio('type', '0', false, ['class' => 'type']) !!}
                            Button
                            {!!  Form::radio('type', '1', true, ['class' => 'type'])  !!}
                        </div>
                    </div>
                </div>

                <!-- Email Service -->
                <div id="email_section" class="form-group" @if(old('type') == '1' || !old('type'))style="display: none"@endif>
                    {!! Form::label('api_id', 'Email Service *', ['class' => 'col-sm-12 control-label page-label']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            {!! Form::select('api_id', $services, null, ['class' => 'form-control']) !!}
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
                                {!! Form::url('website', '', ['placeholder' => 'Website URL', 'class' => 'form-control']) !!}
                                <span class="help-block option-label-new">Website URL where growbar will show.</span>
                            </div>
                        </div>
                    </div>
                    <!-- Call to action URL -->
                    <div class="form-group">
                        {!! Form::label('call_to_action_url', 'Call to action URL', ['class' => 'col-xs-12 control-label page-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::url('link_url', '', ['placeholder' => 'Call to action URL', 'class' => 'form-control']) !!}
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
                                {!! Form::radio('openin', '1', true) !!}
                                No
                                {!!  Form::radio('openin', '0')  !!}
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
                        {!! Form::text('headline', 'Hello. Add your message here.', ['placeholder' => 'Headline', 'class' => 'headline form-control']) !!}
                    </div>
                </div>
            </div>

            <!-- Link Text -->
            <div class="form-group">
                {!! Form::label('link_text', 'Link Text *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('link_text', 'Click Here', ['placeholder' => 'Link Text', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <!-- Font Family -->
            <div class="form-group">
                {!! Form::label('font_family', 'Font Family *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::select('font_family', ['Open Sans'=>'Open Sans', 'Helvetica'=>'Helvetica', 'Arial'=>'Arial', 'Georgia'=>'Georgia', 'Sans-Serif'=>'Sans-Serif'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <!-- Background Color -->
            <div class="form-group">
                {!! Form::label('background_color', 'Background Color', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group background_color">
                            {!! Form::text('background_color', old('background_color'), ['placeholder' => 'Background Color', 'class' => ' form-control colpick']) !!}
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
                            {!! Form::text('text_color', '', ['placeholder' => 'Text Color', 'class' => ' form-control colpick']) !!}
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
                            {!! Form::text('action_color', '', ['placeholder' => 'Button Color', 'class' => ' form-control colpick']) !!}
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
                            {!! Form::text('action_text_color', '', ['placeholder' => 'Button Text Color', 'class' => ' form-control colpick']) !!}
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
                        {!! Form::select('position', ['Top'=>'Top', 'Bottom'=>'Bottom'], null, ['class' => 'position form-control']) !!}
                    </div>
                </div>
            </div>
            <!-- Bar Size -->
            <div class="form-group">
                {!! Form::label('size', 'Bar Size *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::select('size', ['large'=>'Large - 50px height, 17px font', 'regular'=>'Regular - 30px height, 14px font'], null, ['class' => 'size form-control']) !!}
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
                        {!! Form::radio('animate', '1', '') !!}
                        No
                        {!!  Form::radio('animate', '0', true)  !!}
                    </div>
                </div>
            </div>
            <!-- Wiggle button -->
            <div class="form-group">
                {!! Form::label('wiggle', 'Wiggle button *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        Yes
                        {!! Form::radio('wiggle', '1', '', ['onclick'=> 'wigglebtn()']) !!}
                        No
                        {!!  Form::radio('wiggle', '0', true)  !!}
                    </div>
                </div>
            </div>
            <!-- Allow to hide bar -->
            <div class="form-group">
                {!! Form::label('hidebar', 'Allow to hide bar *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        Yes
                        {!! Form::radio('hidebar', '1', '') !!}
                        No
                        {!!  Form::radio('hidebar', '0', true)  !!}
                    </div>
                </div>
            </div>
            <!-- Pushes page down -->
            <div class="form-group">
                {!! Form::label('push', 'Pushes page down *', ['class' => 'col-sm-12 control-label page-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        Yes
                        {!! Form::radio('push', '1', '') !!}
                        No
                        {!!  Form::radio('push', '0', true)  !!}
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
                            {!! Form::radio('cd', '1', '', ['class'=> 'cd']) !!}
                            No
                            {!! Form::radio('cd', '0', true, ['class'=> 'cd'])  !!}

                        </div>
                    </div>
                </div>
            </div>
            <div id="countDown" style="display: none;">
                <!-- COUNTDOWN Background Color (optional) -->
                <div class="form-group">
                    {!! Form::label('cdbg', 'COUNTDOWN Background Color (optional)', ['class' => 'col-sm-12 control-label page-label']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group cdbg">
                                {!! Form::text('cdbg', '', ['placeholder' => 'COUNTDOWN Background Color (optional)', 'class' => 'form-control colpick']) !!}
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
                                {!! Form::text('cdtext', '', ['placeholder' => 'COUNTDOWN Text Color (optional)', 'class' => 'form-control colpick']) !!}
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
                                {!! Form::text('cdlc', '', ['placeholder' => 'COUNTDOWN Lable Color (optional)', 'class' => 'form-control colpick']) !!}
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
