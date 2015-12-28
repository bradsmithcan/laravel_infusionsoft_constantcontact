@extends('layouts.master')


@section('content')

    <div class="row">
        <p>Your First Name: {{ $userData['FirstName'] or 'DEFfFFF' }}</p>

        <p>Your Second Name: {{ $userData['LastName'] or 'DEFfFFF' }}</p>

        {{--<p>Your Email: {{ $userData['Email'] }}</p>--}}
        @if($user->plan)
            <p>Your Current Plan: {{ ucfirst($user->plan->title) }}</p>
        @endif
        <div class="col-md-6">
            <a href="{{ route("settings.user.edit", $user->id) }}">Edit Account</a>
        </div>
    </div>
@stop