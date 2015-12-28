@extends('layouts.master')

@section('title', 'Manage Links')
@section('content')

<link rel="stylesheet" href="{!! asset('/assets/css/DataTable.css') !!}">

<h1>Manage Links </h1>
<a href="{{url('link/create')}}" class="btn btn-success right">Add Links</a>
<hr>
<table id="DataTable" class="table table-default table-hover table-responsive display" cellspacing="0" width="100%">
<thead>
        <tr>
            <th>Profile</th>
            <th>Date</th>
            <th>Page</th>
            <th>Message</th>
            <th>Clicks</th>
            <th>Conversions</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($links as $link) {
            ?>
            <tr>
                <td><img src="{!! URL::asset('') !!}images/profiles/{{ $link['child_pic_resize'] }}" width="" height="80"></td>
                <td>{{ $link['date_created']}}</td>
                <td>{{ $link['title'] }}</td>
                <td>{{ $link['message'] }}</td>
                <td>{{ $link['clicks'] }}</td>
                <td>{{ $link['conversions'] }}</td>
                <td>

                    @if(!empty($link['custom_short_link']))
                        <a target="_blank" href="{{ $link['service_name'] }}/g/{{ $link['custom_short_link'] }}" class="btn btn-success" style="float: left;">Preview</a>
                    @else
                        <a target="_blank" href="{{ $link['service_name'] }}/g/{{ $link['id'] }}" class="btn btn-success" style="float: left;">Preview</a>
                    @endif

                    <a href="{!! route('link.edit', $link['id']) !!}" class="btn btn-success" style="float: left;margin: 1px;">Edit</a>
                    {!! Form::open(['method' => 'DELETE', 'route'=>['link.destroy', $link['id'] ],'style'=>'float:left;']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
            <?php }
        ?>
    </tbody>
</table>

<script type="text/javascript" src="{!! asset('/assets/js/DataTable.js') !!}"></script>

<script type="text/javascript">

    $( document ).ready(function() {
        $('#DataTable').DataTable();
    });

</script>

@endsection