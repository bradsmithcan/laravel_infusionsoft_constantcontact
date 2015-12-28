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
    <link href='https://fonts.googleapis.com/css?family=Cantarell' rel='stylesheet' type='text/css'>

    <link href="{!! asset('assets/css/newsletter.css') !!}" rel="stylesheet" />
    <link href="{!! asset('assets/plugins/jQuery-File-Upload/css/jquery.fileupload.css') !!}" rel="stylesheet" />
    <link href="{!! asset('assets/plugins/jQuery-Smart-Wizard/styles/smart_wizard.css') !!}" rel="stylesheet" />
    <link href="{!! asset('assets/css/custom.css') !!}" rel="stylesheet" />

    <!--   Core JS Files   -->
    <script src="{!! asset('assets/js/jquery-1.10.2.js') !!}"></script>
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
    </script>
    <script type="text/javascript" src="{!! asset('assets/plugins/bootstrap-colorpicker-master/dist/js/bootstrap-colorpicker.min.js') !!}"></script>

    <script type="text/javascript" src="{!! asset('assets/plugins/jQuery-File-Upload/js/vendor/jquery.ui.widget.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/plugins/jQuery-File-Upload/js/jquery.iframe-transport.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/plugins/jQuery-File-Upload/js/jquery.fileupload.js') !!}"></script>
</head>
<body>
<div style="margin-top: 20px;">
    <div class="col-md-5">
        @yield('content')
    </div>
    <div class="col-md-7">
        @yield('live_content')
    </div>
</div>

</body>
</html>
