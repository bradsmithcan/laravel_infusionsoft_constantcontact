@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Home</div>
                    <div class="panel-body">
                        <p>An email was sent to {{ $email }} on {{ $date }}.</p>
                        <p>Please click the link in it to activate your account.</p>
                        <p>
                        {!! Form::open(['url' => 'resendEmail']) !!}
                            {!! Form::hidden('email', $email) !!}
                            {!! Form::submit('Click here to resend the email') !!}
                           {!! Form::close() !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection