@extends('layouts.master')

@section('title', 'Dashboard')


@section('content')

    <h1>Done. Here is your link</h1>

    <a href="{!! $relink !!}" target="_blank">{!! $relink !!}</a>

@endsection