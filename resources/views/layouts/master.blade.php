<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>UserGrow - @yield('title')</title>

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
    <link href="{!! asset('assets/css/custom.css') !!}" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{!! asset('assets/css/pe-icon-7-stroke.css') !!}" rel="stylesheet" />

    <!--   Core JS Files   -->
    <script src="{!! asset('assets/js/jquery-1.10.2.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('assets/js/bootstrap.min.js') !!}" type="text/javascript"></script>
</head>
<body>
<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="{!! asset('assets/img/sidebar-5.jpg') !!}">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="{!! url() !!}" class="simple-text">
                    UserGrow
                </a>
            </div>
            <ul class="nav">
                <li class="active">
                    <a href="{!! url('/home') !!}">
                        <i class="fa fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(Auth::user()->isAdmin())
                    <li class="dropdown" >
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="pe-7s-user"></i>
                            <span>Admin Portal <b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{!! route('admin.user.index') !!}">
                                    <span>Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="{!! route('admin.domain.index') !!}">
                                    <span>Domains</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                    <!-- User Accounts -->
                    <li class="dropdown" >
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="pe-7s-user"></i>
                            <span>User Accounts <b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{!! route('profile.index') !!}">
                                    <span>Profiles</span>
                                </a>
                            </li>
                            <li>
                                <a href="{!! route('settings.user.index') !!}">
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="{!! route('team.index') !!}">
                                    <span>Team</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--Start Grow Links -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-tasks"></i>
                            <span>Grow Links <b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{!! route('link.create') !!}">
                                    <span>Create Link</span>
                                </a>
                            </li>
                            <li>
                                <a href="{!! route('link.index') !!}">
                                    <span>All Links</span>
                                </a>
                            </li>
                            <li>
                                <a href="{!! route('link.index') !!}">
                                    <span>Charts</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--End Grow Links -->

                    @if( \Auth::user()->isNotChild() )
                    <!--Start Grow Pages  -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-bolt"></i>
                            <span>Grow Pages <b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{!! route('growpage.create') !!}">
                                    <span>Create Grow Page</span>
                                </a>
                            </li>
                            <li>
                                <a href="{!! route('growpage.index') !!}">
                                    <span>All Grow Pages</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--End Grow Pages  -->
                    <!--Start Grow Bars  -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-dedent"></i>
                            <span>Grow Bars  <b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{!! route('growbar.create') !!}">
                                    <span>Create Grow Bar</span>
                                </a>
                            </li>
                            <li>
                                <a href="{!! route('growbar.index') !!}">
                                    <span>All Grow Bars</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--End Grow Bars  -->
                    <!--Start Re-Links  -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-link"></i>
                            <span>Re-Links  <b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{!! route('relink.create') !!}">
                                    <span>Create Re-Link</span>
                                </a>
                            </li>
                            <li>
                                <a href="{!! route('relink.index') !!}">
                                    <span>All Re-Links</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--End Re-Links  -->

                    <!--Email Services  -->
                    <li>
                        <a href="{!! url('emailservice') !!}">
                            <i class="fa fa-flag"></i>
                            <span>Email Services</span>
                        </a>
                    </li>
                    <!--Email Services  -->
                @endif
                <li>
                    <a href="">
                        <i class="fa fa-support"></i>
                        <p>Help</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>
    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">

                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a href="">
                               Account
                            </a>
                        </li>
                        <li>
                            <a href="{!!  url('/auth/logout') !!}">
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
            	@yield('content')
            </div>
        </div>
        <div class="themes">
            	@yield('themes')
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>

                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; 2015 UserGrow.com
                </p>
            </div>
        </footer>
    </div>
</div>
	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="{!! URL::asset('') !!}assets/js/bootstrap-checkbox-radio-switch.js"></script>

	<!--  Charts Plugin -->
	<script src="{!! URL::asset('') !!}assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="{!! URL::asset('') !!}assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="{!! URL::asset('') !!}assets/js/light-bootstrap-dashboard.js"></script>
	<script src="{!! URL::asset('') !!}assets/js/demo.js"></script>

	<script type="text/javascript">
    	$(document).ready(function(){
        	demo.initChartist();
        	$.notify({
            	icon: 'pe-7s-gift',
            	message: "Welcome to <b>UserGrow</b>."
            },{
                type: 'info',
                timer: 4000
            });
    	});
	</script>
</body>
</html>