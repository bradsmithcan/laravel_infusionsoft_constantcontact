<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
    <title>UserGrow - </title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{!! asset('assets/css/light-bootstrap-dashboard.css') !!}" rel="stylesheet"/>
    <!-- Bootstrap core CSS     -->
    <link href="{!! asset('assets/css/bootstrap.min.css') !!}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{!! asset('assets/css/animate.min.css') !!}" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{!! asset('assets/css/demo.css') !!}" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{!! asset('assets/css/pe-icon-7-stroke.css') !!}" rel="stylesheet" />


    <link href="{!! asset('assets/plugins/bootstrap-colorpicker-master/dist/css/bootstrap-colorpicker.min.css') !!}" rel="stylesheet" />

    <link href="{!! asset('assets/css/newsletter.css') !!}" rel="stylesheet" />
    <link href="{!! asset('assets/plugins/jQuery-File-Upload/css/jquery.fileupload.css') !!}" rel="stylesheet" />
    <link href="{!! asset('assets/plugins/jQuery-Smart-Wizard/styles/smart_wizard.css') !!}" rel="stylesheet" />
    <link href="{!! asset('assets/css/style.default.css') !!}" rel="stylesheet" />
    <link href="{!! asset('assets/css/custom.css') !!}" rel="stylesheet" />

    <!--   Core JS Files   -->
    <script src="{!! asset('assets/js/jquery-1.10.2.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('assets/js/bootstrap.min.js')!!}" type="text/javascript"></script>
    <script src="{!! asset('assets/plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js')!!}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            // Smart Wizard
            $('#wizard').smartWizard();

            function onFinishCallback(){
                $('#wizard').smartWizard('showMessage','Finish Clicked');
                alert('Finish Clicked');
            }
        });
        function wigglebtn() {
            $(".gb-headline-btn").removeClass('wiggle');
            $(".gb-headline-btn").addClass('wiggle');
        }
    </script>
    <script type="text/javascript" src="{!! asset('assets/plugins/bootstrap-colorpicker-master/dist/js/bootstrap-colorpicker.min.js')!!}"></script>

    <script type="text/javascript" src="{!! asset('assets/plugins/jQuery-File-Upload/js/vendor/jquery.ui.widget.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/plugins/jQuery-File-Upload/js/jquery.iframe-transport.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/plugins/jQuery-File-Upload/js/jquery.fileupload.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/plugins/countdown/countdown.js') !!}"></script>

</head>
<body>
<div id="growbar_admin" class="large remains_in_place bar-top" style="background-color:@if(old('background_color')) {!! old('background_color').';' !!}  @elseif(isset($growBar['background_color'])) {!! $growBar['background_color'].';'  !!} @else #eb593c; @endif color: @if(old('text_color')) {!! old('text_color').';' !!} @elseif(isset($growBar['text_color'])) {!! $growBar['text_color'].';'  !!} @else #ffffff; @endif font-family: @if(old('font_family')) {!! old('font_family').';' !!}  @elseif(isset($growBar['font_family']))  {!! $growBar['font_family'].';'  !!} @else 'Open Sans'; @endif border-color:#ffffff;">
    <div class="gb-logo-wrapper">
        <span>UserGrow</span>
    </div>
    <div class="gb-content-wrapper">
        <div>
            <span id="gb_msg_container" class="gb-headline-text gb-text-wrapper">
                @if(old('headline')) {!! old('headline') !!} @elseif(isset($growBar['headline'])) {!! preg_match('/[[gcdown]]/', $growBar['headline']) ? explode('[[gcdown]]',$growBar['headline'])[2] : $growBar['headline'] !!}  @else Hello. Add your message here. @endif

                @if(isset($growBar['headline']) && preg_match('/[[gcdown]]/', $growBar['headline']))
                    <span id="gb-headline-counter-holder"></span>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $(this).changeCountDown();
                            });
                        </script>
                @endif
            </span>

            <span id="theform" style="@if(old('type') == '1') display: none; @elseif(isset($growBar['type']) && $growBar['type'] == '1') display: none;@elseif(!isset($growBar['type'])) display: none;  @endif">
                <span class="btn">
                    <input type="email" placeholder="Email Address" required="" class="form-control" id="email-Full-Width" name="email">
                </span>
            </span>
            <span class="gb-headline-btn-holder" id="gb-headline-btn-holder">
                <a href="#" class="gb-headline-btn" id="gb_headline_btn" style="background-color: @if(old('action_color'))  {!! old('action_color') !!}  @elseif(isset($growBar['action_color'])) {!! $growBar['action_color'] !!} @endif ;color: @if(old('action_text_color'))  {!! old('action_text_color').';' !!}  @elseif(isset($growBar['action_text_color'])) {!! $growBar['action_text_color'].';'  !!} @endif " >@if(old('link_text')) {!! old('link_text') !!}  @elseif(isset($growBar['link_text'])) {!! $growBar['link_text']  !!} @else Click Here @endif </a>
            </span>
        </div>

    </div>
    <div class="gb-arrow-wrapper">
        <a href="#" id="close_bar" onclick="window.parent.HB.animateOut(window.parent.HB.w);
            if(window.parent.HB.e.pusher != null) window.parent.HB.e.pusher.style.display = 'none'; window.parent.HB.animateIn(window.parent.document.getElementById('pull-down'));">
            <img class="gb-arrow" src="{!! asset('assets/images/arrow_white.png') !!}" alt="" width="28" height="29">
        </a>
    </div>
</div>
<div >
    <div class="col-md-6">
        @yield('content')
    </div>
    <div class="col-md-6">
        <div style="position:fixed;top:30%;right:0;width:350px;background:#fff;color:#333;z-index:99999;padding:20px;">Countdown can be enabled in your headline by using the shortcode format below:
    <textarea id="foo" style="width:100%;padding:5px 5px;" onFocus="this.select();">
    [[gcdown]]{!! date("Y/m/d H:i:s", time() + 86400 ) !!} [[gcdown]]</textarea>
            <div class="alert alert-info">Countdown's are disabled in our preview but will be dynamically generated on your website once the growbar script is activated.

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('.background_color').colorpicker({
            @if(old('background_color'))
                 color: "{!! old('background_color') !!}",
            @elseif(isset($growBar['background_color']))
                 color: "{!! $growBar['background_color'] !!}",
            @else
                color: "#eb593c",
            @endif
        }).on('changeColor.background_color', function(event){
            $('#growbar_admin').css('background-color', event.color.toHex());
        });

        $('.text_color').colorpicker({
            @if(old('text_color'))
                 color: "{!! old('text_color') !!}",
            @elseif(isset($growBar['text_color']))
                 color: "{!! $growBar['text_color'] !!}",
            @else
                color: "#ffffff",
            @endif
        }).on('changeColor.text_color', function(event){
            $('#gb_msg_container').css('color', event.color.toHex());
            $('.gb-logo-wrapper').css('color', event.color.toHex());
        });

        $('.action_color').colorpicker({
            @if(old('action_color'))
                 color: "{!! old('action_color') !!}",
            @elseif(isset($growBar['action_color']))
                 color: "{!! $growBar['action_color'] !!}",
            @else
                color: "green",
            @endif
        }).on('changeColor.action_color', function(event){
            $('#gb_headline_btn').css('background-color', event.color.toHex());
        });

        $('.action_text_color').colorpicker({
            @if(old('action_text_color'))
                 color: "{!! old('action_text_color') !!}",
            @elseif(isset($growBar['action_text_color']))
                 color: "{!! $growBar['action_text_color'] !!}",
            @else
                color: "#ffffff",
            @endif
         }).on('changeColor.action_text_color', function(event){
            $('#gb_headline_btn').css('color', event.color.toHex());
        });

        $('.cdtext').colorpicker({
            @if(old('cdtext'))
                 color: "{!! old('cdtext') !!}",
            @elseif(isset($growBar['cdtext']))
                 color: "{!! $growBar['cdtext'] !!}",
            @else
                color: "#fff",
            @endif
        }).on('changeColor.cdtext', function(event){
            $(this).changeCountDown();
        });


         $('.cdbg').colorpicker({
            @if(old('cdbg'))
                 color: "{!! old('cdbg') !!}",
            @elseif(isset($growBar['cdbg']))
                 color: "{!! $growBar['cdbg'] !!}",
            @else
                color: "#000000",
            @endif
         }).on('changeColor.cdbg', function(event){
             $(this).changeCountDown();
        });

        $('.cdlc').colorpicker({
            @if(old('cdlc'))
                 color: "{!! old('cdlc') !!}",
            @elseif(isset($growBar['cdlc']))
                 color: "{!! $growBar['cdlc'] !!}",
            @else
                color: "#000000",
            @endif
        }).on('changeColor.cdlc', function(event){
            $(this).changeCountDown();
        });
    });
    jQuery.fn.changeCountDown = function()
    {
        var str = $('#headline').val();
        if(str.indexOf("[[gcdown]]") >= 0 ){
            var fulldata = $('#headline').val().split("[[gcdown]]");

            var dataarray = fulldata[1].split(' ');

            var data = dataarray[0];
            var timearr = dataarray[1];


            var date = data.split('/');
            var year	= date[0];
            var month	= date[1];
            var day	    =  date[2];

            var time	= timearr.split(':');
            var hour	= time[0];
            var minute	= time[1];
            var second	= time[2];

            var date1 = new Date(fulldata[1]);
            var date2 = new Date();
            var diff	= date1 - date2;

            var range = diff > 86400?'day':(diff > 3600 ? 'hour':'minute');

            var cdbg = $('#cdbg').val();
            var cdlc = $('#cdlc').val();
            var cdtext = $('#cdtext').val();

            var text = $('#headline').val().split("[[gcdown]]");

            if(Date.parse(text[1]) && text[0].trim() ){
                $('#gb-headline-counter-holder').empty();
                $('#gb_msg_container').empty();
                $('#gb_msg_container').html(text[0]);
                $('#gb_msg_container').append('<span id="gb-headline-counter-holder"></span>');
                setcountdown(cdbg, cdlc, cdtext, year, month, day, hour, minute, second, range);
            }else{
                $('#gb-headline-counter-holder').empty();
                $('#gb_msg_container').empty();
                $('#gb_msg_container').html('<span id="gb-headline-counter-holder"></span>');
                $('#gb_msg_container').append(text[2]);
                setcountdown(cdbg, cdlc, cdtext, year, month, day, hour, minute, second, range);
            }
        } else{
            $('#gb_msg_container').html($(this).val());
        }
    };

    $('.type').change(function(){
        var type = $('input[name="type"]:checked').val();
        if(type == '0'){
            $('#theform').show();
            $('#email_section').slideDown();

        }else{
            $('#theform').hide();
            $('#email_section').slideUp();
        }
    });

    $('.position').change(function(){
        var val = $( "#position" ).val();
        if($('#growbar_admin').hasClass('bar-top')){
            $('#growbar_admin').removeClass('bar-top');
            $('#growbar_admin').addClass('bar-bottom');
        }else{
            $('#growbar_admin').removeClass('bar-bottom');
            $('#growbar_admin').addClass('bar-top');
        }
    });
    $('.size').change(function(){
        var val = $( "#size" ).val();
       if($('#growbar_admin').hasClass('regular')){
           $('#growbar_admin').removeClass('regular');
           $('#growbar_admin').addClass('large');
       }else{
           $('#growbar_admin').removeClass('large');
           $('#growbar_admin').addClass('regular');
       }
    });
    $('#headline').bind("keyup change", function(){
        $(this).changeCountDown();
    });
    $('#link_text').keyup(function(){
        $('#gb_headline_btn').html($(this).val());
    });
    $('#font_family').change(function(){
        var val = $( "#font_family" ).val();
        $('#gb_msg_container').css('font-family', val);
        $('#gb_headline_btn').css('font-family', val);
    });

    $('.cd').change(function(){
        var countDown = $('input[name="cd"]:checked').val();
        if(countDown == '1'){
            $('#countDown').show();
        }else{
            $('#countDown').hide();
        }
    });

    function setcountdown(cdbg, cdlc, cdtext, year, month, day, hour, minute, second, range){
        year = year || new Date().getFullYear();
        month = month || new Date().getMonth()+1;
        day = day || new Date().getDate()+1;
        hour = hour || new Date().getHours();
        minute = minute || new Date().getMinutes();
        second = second || new Date().getSeconds();
        range = range || 'day';

        var myCountdown4 = new Countdown({
            year: year,
            month: month,
            day: day,
            hour: hour,
            minute: minute,
            second: second,
            target:"gb-headline-counter-holder",
            hideLine: 1,
            rangeHi		: range,
            rangeLo		: "second",
            width:160,
            height:38,
            labels : {
                font   : "Arial",
                color  : cdlc,
                weight : "normal" // < - no comma on last item!
            },
            numbers		: 	{
                font 	: "Arial",
                color	: cdtext,
                bkgd	: cdbg,
                fontSize : 150,
                rounded	: 0.15,				// percentage of size
                shadow	: {
                    x : 0,			// x offset (in pixels)
                    y : 3,			// y offset (in pixels)
                    s : 4,			// spread
                    c : "#000000",	// color
                    a : 0.4			// alpha	// <- no comma on last item!
                }
            }
        });
    }
</script>
</body>
</html>
