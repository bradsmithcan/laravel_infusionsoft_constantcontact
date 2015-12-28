@extends('app2')

@section('content')

	@if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (Session::has('message'))
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            {!! Session::get('message') !!}
        </ul>
    </div>
    @endif
    
	<div class="inset">
        <div class="login-head">
            <h1>UserGrow Login</h1>
        </div>
            <form method="post" action="{{ url('/auth/login') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <li>
                    <input type="email" name="email" class="text" value="you@email.com" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '{{ old('email') }}';}"><a href="#" class=" icon user"></a>
                </li>
                    <div class="clear"> </div>
                <li>
                    <input type="password" name="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}"> <a href="#" class="icon lock"></a>
                </li>
                
                <li>
                	<label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </li>
                <div class="clear"> </div>
                <div class="submit">
                    <input type="submit" onclick="myFunction()" value="Sign in" >
                    <h4><a href="{{ url('/password/email') }}">Lost your Password?</a></h4>
                              <div class="clear">  </div>	
                </div>
                    
            </form>
            </div>					
    </div>

@endsection
