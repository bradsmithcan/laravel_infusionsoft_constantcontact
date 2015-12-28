@extends('layouts.link_master')
@section('title', 'Edit Links')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<div id="mainModal" class="modal" tabindex="-1" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content" style="padding-bottom: 30px;">
            <div class="modal-header">
                Update link
            </div>

            <div id="modal-body">

                <div class="panel panel-default" style="overflow: auto;position: relative;">

                    <div class="panel-body" style="padding-bottom: 40px;">

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Link Components</h4>
                </div>

                <div id="modal-body" ></div>
            </div>
        </div>
    </div>
    {!! Form::open(['method' => 'PUT', 'route'=>['link.update', $snip_data['id']]]) !!}
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('user_id', 'User:') !!}
        </div>
        <div class="col-xs-12">
            {!!  	Form::select('user_id', $users, $snip_data['user_id'] , ['onchange' => 'addprofile();', 'class' => 'form-control', 'id'=> 'mypro'])!!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('domain_id', 'Domain:') !!}
        </div>
        <div class="col-xs-12">
            {!!  	Form::select('domain_id', $domains, $snip_data['domain_id'] , [ 'class' => 'form-control', 'id'=> 'domains'])!!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('feed_type', 'Type:') !!}
        </div>
        <div class="col-xs-12">
            {!!  	Form::select('feed_type', $feed_type, old('feed_type') , ['id' => 'type_selector', 'class' => 'form-control'])!!}
            <a href="http://usergrow.com/feed.rss" target="_blank">Example Input RSS feed</a>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('page_url', 'Page URL:') !!}
        </div>
        <div class="col-xs-12">
            {!! Form::hidden('table','snips') !!}
            {!! Form::url('page_url', $snip_data['page_url'],['id'=>'page_url', 'class'=>'form-control', 'placeholder'=>'http://pageurl.com']) !!}
            <span class="help-block option-label-new">Please format your URL like this: http://pageurl.com</span>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('short_link_type', 'Short Link:') !!}
        </div>
        <div class="col-xs-12">
            {!! Form::radio('shortRadios', '1', true ,['id'=>'shortRadios', 'class'=>'action_type_short_link']) !!} {!! Form::label('shortRadios', 'Default') !!}
            {!! Form::radio('shortRadios', '2', false, ['id'=>'shortRadios-link', 'class'=>'action_type_short_link']) !!} {!! Form::label('shortRadios', 'Custom Short Link') !!}
        </div>
    </div>

    <div id="custom_short_link" class="form-group" style="display: none;">
        <div class="col-xs-12">
            {!! Form::label('custom_short_link', 'Custom Short Link:') !!}
        </div>
        <div class="col-xs-12">
            {!! Form::url('short_url', $snip_data['custom_short_link'], ['id'=>'short_url', 'class'=>'form-control', 'placeholder'=>'xxx', 'onkeypress'=>'checkShortLink()'] ) !!}
            <span class="help-block" id="short_url_msg" style="display:none;" ></span>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('action_type', 'Action Type:') !!}
        </div>
        <div class="col-xs-12">
            {!! Form::radio('optionsRadios', 'button', (($snip_data['snip_type']=='button')?true:false) ,['id'=>'optionsRadios', 'class'=>'action_type_opt']) !!} {!! Form::label('optionsRadios', 'Button') !!}
            {!! Form::radio('optionsRadios', 'form', (($snip_data['snip_type']=='form')?true:false), ['id'=>'optionsRadios-form', 'class'=>'action_type_opt']) !!} {!! Form::label('optionsRadios', 'Form Opt-in') !!}
        </div>
    </div>
    <div id="email_services" class="form-group" style="display: {!! (($snip_data['snip_type']=='form')?'block':'none')!!};">
        <div class="col-xs-12">
            {!! Form::label('email_service_id', 'Email Services:') !!}
        </div>
        <div class="col-xs-12">
            {!!  	Form::select('email_service_id', $email_services, $snip_data['service_id'] , [ 'class' => 'form-control', 'id'=> 'email_service_id'])!!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('inputMessage', 'Message') !!}
        </div>
        <div class="col-xs-12">
            {!! Form::text('inputMessage', $snip_data['message'], ['id'=>'inputMessage', 'placeholder' => 'Enter Your Message', 'class' => 'form-control', 'required'=>'true']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('snip_remarketing_code', 'Retargeting Code', ['class' => 'text-align-left']) !!}
        </div>
        <div class="col-xs-12">
            {!! Form::textarea('snip_remarketing_code', $snip_data['snip_remarketing_code'], ['id' => 'snip_remarketing_code', 'placeholder' => 'Enter Your Retargeting Code Here', 'rows' => '5','class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('button_text', 'Button Text', ['class' => 'text-align-left']) !!}
        </div>
        <div class="col-xs-12">
            {!! Form::text('button_text', $snip_data['button_text'], ['id'=>'button_text', 'placeholder' => 'Button Text', 'class' => 'form-control', 'onblur'=>'buttontext();']) !!}
        </div>

    </div>
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('button_url', 'Button URL', ['class' => 'text-align-left']) !!}
        </div>
        <div class="col-xs-12">
            {!! Form::url('button_url',  $snip_data['button_url'], ['id'=>'button_url', 'placeholder' => 'http://usergrow.com', 'class' => 'form-control']) !!}
        </div>

    </div>
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('background_color', 'Background Color', ['class' => 'text-align-left']) !!}
        </div>
        <div class="col-xs-12">
            {!! Form::text('background_color', $snip_data['background_color'], ['id'=>'bggcolor', 'class' => 'pick-a-color form-control']) !!}
        </div>

    </div>
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('text_color', 'Text Color', ['class' => 'text-align-left']) !!}
        </div>
        <div class="col-xs-12">
            {!! Form::text('text_color', $snip_data['text_color'], ['id'=>'text_color', 'class' => 'pick-a-color1 form-control']) !!}
        </div>

    </div>
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('action_color', 'Action Color', ['class' => 'text-align-left']) !!}
        </div>
        <div class="col-xs-12">
            {!! Form::text('action_color', $snip_data['action_color'], ['id'=>'action_color', 'class' => 'pick-a-color2 form-control']) !!}
        </div>

    </div>
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('action_text_color', 'Action Text Color', ['class' => 'text-align-left']) !!}
        </div>
        <div class="col-xs-12">
            {!! Form::text('action_text_color', $snip_data['action_text_color'], ['id'=>'action_text_color', 'class' => 'pick-a-color3 form-control']) !!}
        </div>

    </div>
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('theme', 'Theme:') !!}
        </div>
        <div class="col-xs-12">
            {!!  	Form::select('theme', $themes, $snip_data['theme'] , ['id' => 'theme_type', 'class' => 'form-control', 'onchange'=>'changetheme()'])!!}
        </div>
    </div>

    <input type="hidden" name="snip_id" id="snip_id" value="{!! $snip_data['id'] !!}" />
    <input type="hidden" name="_token" id="is_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="is_candy" id="is_candy" value="2" />
    <input type="hidden" name="timestamp" id="timestamp" value="{{{ $timestamp}}}" />
    <input type="hidden" name="hash" id="hash" value="{{{$hash}}}" />
    <input type="hidden" name="user_id" id="user_id" value="1" />
    <input type="hidden" name="path" id="path" value="1" />
    <input type="hidden" name="s_id" id="s_id" value="1" />

    <div class="form-group hidden" id="full_wid_img">
        <div class="col-xs-12"><label class="control-label" for="upload_path">Image</label></div>

        <div class="col-xs-12">
            <input type="hidden" name="file_name" id="file_name" value="" />
            <input type="hidden" name="i_id" id="i_id" value="" />
            <span id="user_uploader_div">
                <div id="fullWidthImagefileuploader">Upload</div>
            </span>

            <span id="error_upload_msg" class="alert alert-danger hidden" style="float:left;">
                Please upload Image
            </span>
            <input class="form-control" type="hidden" name="upload_path" id="upload_path_id" value="1"  />
            <input class="form-control" type="hidden" name="candy_upload_path" id="candy_upload_path_id"  value="1" />

        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            {!! Form::label('position', 'Position:') !!}
        </div>
        <div class="col-xs-12">
            {!! Form::select('position', $position, $snip_data['position'] , ['id' => 'post_text', 'class' => 'form-control'])!!}
        </div>
    </div>
    <div class="form-group ">
        <div class="col-xs-3">
            <br/>
            <a class="btn btn-default form-control col-xs-2 col-lg-2 col-md-2 col-sm-2" href="/home">CANCEL</a>
        </div>
        <div class="col-xs-4 col-lg-offset-5">
        <br/>
            <img src="{!! URL::asset('') !!}assets/images/select2-spinner.gif" id="loadload" style="display: none;"/>
            {!! Form::submit('Update', ['id'=>'mysnips-edit', 'class' => 'btn btn-default form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
                </div>
            </div>

<script type="text/javascript">

    function addprofile() {
        var pro = $('#mypro option:selected').val();
        if (pro == "addprofile") {
            window.location.href = "/profile";
        }
    }
</script>
<!--<link href="{!! URL::asset('') !!}assets/css/bootstrap-colorpicker.min.css" rel="stylesheet">-->
<link rel="stylesheet" href="{!! URL::asset('') !!}assets/css/pick-a-color-1.2.3.min.css" />
<link href="{!! URL::asset('') !!}assets/css/custom_theme.css" rel="stylesheet" />
<!--<script src="{!! URL::asset('') !!}assets/js/bootstrap.min.js"></script>-->
<script src="{!! URL::asset('') !!}assets/js/common_link.js"></script>
<script src="{!! URL::asset('') !!}assets/js/tinycolor-0.9.15.min.js"></script>
<script src="{!! URL::asset('') !!}assets/js/pick-a-color-1.2.3.min.js"></script>
<script src="{!! URL::asset('') !!}assets/js/colpick.js" type="text/javascript"></script>

<link rel="stylesheet" href="{!! URL::asset('') !!}assets/css/colpick.css" type="text/css"/>
<link href="/fileupload/uploadfile.css" rel="stylesheet">
<script src="/fileupload/jquery.uploadfile.js"></script>
<style type="text/css">
    .pick-a-color {
        border-right:20px solid green;
    }
    .pick-a-color1 {
        border-right:20px solid green;
    }
    .pick-a-color2 {
        border-right:20px solid green;
    }
    .pick-a-color3 {
        border-right:20px solid green;
    }
</style>

<script type="text/javascript">
    $(window).load(function () {
<?php if (isset($_POST['homeurl']) && !empty($_POST['homeurl'])) { ?>
            $('#page_url').val('<?php echo $_POST['homeurl']; ?>');
            $('#page_url').change();
<?php } ?>
    });
</script>
<?php
if (!empty($varlink)) {
    ?>
    <script type="text/javascript">
        $(window).load(function () {
            $('#iframetest').height($(window).height());
            $('#iframetest').html('<iframe src="<?php echo $varlink; ?>" style="overflow:hidden; width: 100%; height:100%" width: 100%; height:100% ></iframe>');

        });
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#mainModal').modal('show');

            $('#mainModal').on('show.bs.modal', function () {
                $('.modal .modal-body').css('overflow-y', 'auto');
            });



            $("#page_url").change(function () {

                $('#iframetest').height($(window).height());

                var valuedata = $(this).val();
                if (valuedata && !valuedata.match(/^http([s]?):\/\/.*/)) {
                    valuedata = 'http://' + valuedata;
                }

                $.ajax({
                    url: "/links/system?action=" + $("#type_selector :selected").val() + "&id=" + $(this).val(),
                    type: "GET",
                    async: false,
                    success: function (data) {

                        if (data == "invalid") {

                            $(".option-label-new").html("<div class='alert alert-danger'>Invalid Rss Feed URL! Pattern Not Matched</div>");

                        }

                    }
                });

                $('#iframetest').html('<iframe src="' + valuedata + ' " style="overflow:hidden; width: 100%; height:100%" width: 100%; height:100% ></iframe>');

            });
        });
    </script>
<?php } ?>

<script>

    $(document).ready(function () {
        $("#inputMessage").change(function () {

            $('#profile_left_msg').html(' ' + $(this).val() + ' ');
            $('#profile_left_msg2').html(' ' + $(this).val() + ' ');
            $('#profile_left_msg3').html(' ' + $(this).val() + ' ');
            $('#profile_left_msg4').html(' ' + $(this).val() + ' ');
            $('#profile_left_msg5').html(' ' + $(this).val() + ' ');
            $('#profile_left_msg6').html(' ' + $(this).val() + ' ');

        });

        $("#button_text").change(function () {
            $(".snip_click").val($('#button_text').val());
        });

    });
</script>
<script type="text/javascript">

    $(document).ready(function () {

        set_iframe();

        $("#page_url").on("change",function(){

            set_iframe();

        });

        $("#type_selector").on("change", function (e) {

            var rss = "http://pageurl/rss.rss";
            var url = "http://pageurl.com";
            var trap_it = "http://example/trap.it/atom"
            var field = "Please format your URL like this: ";

            if ($(this).val() == "RSS feed") {

                $(".option-label-new").html(field + rss);
                $("#page_url").attr("placeholder", rss);

            }
            if ($(this).val() == "Trap.it feed") {

                $(".option-label-new").html(field + trap_it);
                $("#page_url").attr("placeholder", url);

            } else {

                $(".option-label-new").html(field + url);
                $("#page_url").attr("placeholder", url);

            }

            $(".page-label").html($(this).val());

        });

        $("#mypro").on("change", function (e) {

            $.ajax({
                url: "/links/system",
                type: "POST",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {_token: $('#is_token').val(), action: "profile", id: $(this).val()},
                success: function (data) {
                    var data = jQuery.parseJSON(data);
                    var theme = $("#theme_type :selected").val().toLowerCase();

                    $(".profile_pic img").attr("src", data.pic);
                    $(".profile_info .profile_left a").text(data.name);

                }
            });

        });

        $('#myModal').on('hide.bs.modal', function (e) {
            window.location = "{{url('/link')}}";
        });

        $("#theme_type").on("change", function (e) {

            change_position();

        });

        $("#post_text").on("change", function (e) {

            change_position();

        });

        $('.pick-a-color').colpick({
            layout: 'hex',
            submit: 0,
            colorScheme: 'dark',
            onChange: function (hsb, hex, rgb, el, bySetColor) {
                $(el).css('border-color', '#' + hex);
                // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
                if (!bySetColor)
                    $(el).val(hex);
                $(".profile_info,.glink-bg,.talking").css('background', '#' + hex);
                $(".profile_info_social,.glink-bg,.talking").css('background', '#' + hex);
                // $(".profile_info,.glink-bg,.talking").css('background','#'+$("#bggcolor").val(hex));

            }
        }).keyup(function () {
            $(this).colpickSetColor(this.value);
        });

        $('.pick-a-color1').colpick({
            layout: 'hex',
            submit: 0,
            colorScheme: 'dark',
            onChange: function (hsb, hex, rgb, el, bySetColor) {
                $(el).css('border-color', '#' + hex);
                // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
                if (!bySetColor)
                    $(el).val(hex);
                $('.profile_left.name a,span.msg').css('color', '#' + hex);
                //$(".profile_info,.glink-bg,.talking").css('background','#'+$("#bggcolor").val(hex));
            }
        }).keyup(function () {
            $(this).colpickSetColor(this.value);
        });
        $('.pick-a-color2').colpick({
            layout: 'hex',
            submit: 0,
            colorScheme: 'dark',
            onChange: function (hsb, hex, rgb, el, bySetColor) {
                $(el).css('border-color', '#' + hex);
                // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
                if (!bySetColor)
                    $(el).val(hex);
                $(".btn-theme").css('background', '#' + hex);
                //$(".profile_info,.glink-bg,.talking").css('background','#'+$("#bggcolor").val(hex));
            }
        }).keyup(function () {
            $(this).colpickSetColor(this.value);
        });
        $('.pick-a-color3').colpick({
            layout: 'hex',
            submit: 0,
            colorScheme: 'dark',
            onChange: function (hsb, hex, rgb, el, bySetColor) {
                $(el).css('border-color', '#' + hex);
                // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
                if (!bySetColor)
                    $(el).val(hex);
                $('.btn-theme').css('color', '#' + hex);
                //$(".profile_info,.glink-bg,.talking").css('background','#'+$("#bggcolor").val(hex));
            }
        }).keyup(function () {
            $(this).colpickSetColor(this.value);
        });
    });

    function set_iframe(){

        $('#iframetest').height($(window).height());

        var valuedata = $("#page_url").val();

        if (valuedata && !valuedata.match(/^http([s]?):\/\/.*/)) {
            valuedata = 'http://' + valuedata;
        }

        $.ajax({
            url: "/links/system?action=" + $("#type_selector :selected").val() + "&id=" + $("#page_url").val(),
            type: "GET",
            async: false,
            success: function (data) {

                if (data == "invalid") {

                    $(".option-label-new").html("<div class='alert alert-danger'>Invalid Rss Feed URL! Pattern Not Matched</div>");

                }

                if (data == "valid") {

                    $(".option-label-new").html("<div class='alert alert-success'>Valid Rss Feed URL!</div>");

                }

            }
        });

        $('#iframetest').html('<iframe src="' + valuedata + ' " style="overflow:hidden; width: 100%; height:100%" width: 100%; height:100% ></iframe>');

    }

    function change_position() {

        var theme = $("#theme_type option:selected").val().toLowerCase();
        var newval = $("#post_text option:selected").val();

        if (newval == "Top_Left") {

            $('#' + theme).removeClass('bottom-right-div');
            $('#' + theme).removeClass('bottom-left-div');
            $('#' + theme).removeClass('top-right-div');
            $('#' + theme).addClass('top-left-div');

        }

        if (newval == "Top_Right") {

            $('#' + theme).removeClass('bottom-right-div');
            $('#' + theme).removeClass('bottom-left-div');
            $('#' + theme).removeClass('top-left-div');
            $('#' + theme).addClass('top-right-div');

        }

        if (newval == "Bottom_Left") {

            $('#' + theme).removeClass('bottom-right-div');
            $('#' + theme).removeClass('top-left-div');
            $('#' + theme).removeClass('top-right-div');
            $('#' + theme).addClass('bottom-left-div');

        }

        if (newval == "Bottom_Right") {

            $('#' + theme).removeClass('top-left-div');
            $('#' + theme).removeClass('bottom-left-div');
            $('#' + theme).removeClass('top-right-div');
            $('#' + theme).addClass('bottom-right-div');

        }

    }
    jQuery(document).ready(function ()
    {
        var settings = jQuery("#fullWidthImagefileuploader").uploadFile({
            url: "/uploadify/uploadify.php",
            method: "POST",
            allowedTypes: "jpg,png,JPEG,JPG,PNG",
            fileName: "Filedata",
            multiple: false,
            maxFileCount: 1,
            autoSubmit: true,
//      showStatusAfterSuccess: false,
            maxFileSize: 1024 * 1000,
            formData: {
                'timestamp': jQuery("#timestamp").val(),
                'token': jQuery("#hash").val(),
                '_token': jQuery("#_token").val(),
                'path': jQuery("#path").val(),
                's_id': jQuery("#s_id").val(),
                'type': 'image',
            },
            onSubmit: function (files)
            {

            },
            onSuccess: function (files, data, xhr)
            {
                if ($('#is_candy').val() == 1) {
                    $('#candy_upload_path_id').val(data);
                    $('#candy_profile_left_img').html("<img style='width:250px;' id='theImg' src='" + data + "'/>");
                } else {
                    $('#upload_path_id').val(data);
                    $('#profile_left_img').html("<img width='150' height='150' id='theImg' src='" + data + "'/>");
                }
                $('.ajax-file-upload-statusbar').css('display', 'none');


            },
            afterUploadAll: function ()
            {


            },
            onError: function (files, status, errMsg)
            {

            }
        });

        
    });
    
    function checkShortLink(){
                    $.ajax({
                url: "/link/checkShortLink",
                type: "POST",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {_token: $('#is_token').val(), short_link: $('#short_url').val()},
                success: function (data) {
                    var data = jQuery.parseJSON(data);

                    $("#short_url_msg").slideDown('fast');
                    $("#short_url_msg").attr('class',data.class);
                    $("#short_url_msg").html(data.msg);


                }
            });

    }
jQuery(document).on('onkeypress', "#short_url", function (e) {
alert('press');


        });
    
</script>

@endsection
@section('themes')
@include('partial.theme_social')
@include('partial.theme_bean')
@include('partial.theme_bigCandy')
@include('partial.theme_candy')
@include('partial.theme_fullWidth')
@endsection
