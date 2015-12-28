@extends('app2')

@section('content')

	@if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
					@endif

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
                    
	<div class="inset">
        <div class="login-head">
            <h1>UserGrow | Reset Password</h1>
        </div>
            <form method="post" action="{{ url('/password/email') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <li>
                    <input type="email" class="form-control" name="email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '{{ old('email') }}';}"><a href="#" class=" icon user"></a>
                </li>
                    <div class="clear"> </div>
                <div class="clear"> </div>
                <div class="submit">
                    <input type="submit" onclick="myFunction()" value="Reset Password">
                              <div class="clear">  </div>	
                </div>
                    
            </form>
            </div>					
    </div>
  
@endsection
