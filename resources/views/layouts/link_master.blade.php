<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>UserGrow - @yield('title')</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{!! URL::asset('') !!}assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{!! URL::asset('') !!}assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{!! URL::asset('') !!}assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{!! URL::asset('') !!}assets/css/demo.css" rel="stylesheet" />
    <link href="{!! URL::asset('') !!}assets/css/custom.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{!! URL::asset('') !!}assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

    <!--   Core JS Files   -->
    <script src="{!! URL::asset('') !!}assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="{!! URL::asset('') !!}assets/js/bootstrap.min.js" type="text/javascript"></script>

</head>
<body>
        <iframe id="iframe-preview" frameborder="0" id="ContentFrame" style="border: 0 none;bottom: 0;height: 100%;left: 0;min-width: 100%;overflow: scroll;    position: absolute; right: 0;  top: 0;width: 10px;" src=""></iframe>

        <div class="wrapper">
            <div class="content col-lg-6 col-lg-offset-3" style="margin-top: 30px;position: relative;">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <div class="themes">
                @yield('themes')
            </div>
        </div>
</body>
	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="{!! URL::asset('') !!}assets/js/bootstrap-checkbox-radio-switch.js"></script>

	<!--  Charts Plugin -->
	<!--<script src="{!! URL::asset('') !!}assets/js/chartist.min.js"></script>-->

    <!--  Notifications Plugin    -->
    <script src="{!! URL::asset('') !!}assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="{!! URL::asset('') !!}assets/js/light-bootstrap-dashboard.js"></script>
	<!--<script src="{!! URL::asset('') !!}assets/js/demo.js"></script>-->

	<script type="text/javascript">
    	$(document).ready(function(){
//        	demo.initChartist();
        	$.notify({
            	icon: 'pe-7s-gift',
            	message: "Welcome to <b>UserGrow</b>."
            },{
                type: 'info',
                timer: 4000
            });
    	});
	</script>
</html>