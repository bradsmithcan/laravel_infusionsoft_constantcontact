@extends('layouts.master')

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        <div class="row">
            <div class="col-xs-12">
                {!! Form::label('file', 'Add Background', ['class' => 'control-label page-label']) !!}
            </div>
        </div>
        <div class="row">
            {!! Form::open(array('url' => 'admin/backgrounds', 'files' => true)) !!}
                <div class="col-xs-10 col-sm-6 col-md-5 col-lg-3">
                    {!! Form::file('file',['class' => 'create-background-input']) !!}
                </div>
                <div class="col-xs-2">
                    {!! Form::submit('Add', ['class' => 'btn btn-success']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    <link rel="stylesheet" href="{!! asset('/assets/css/DataTable.css') !!}">

    <div id="DeleteBackgroundModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Background</h4>
                </div>
                <div class="modal-body">
                    <div>Please confirm DELETE.</div>
                </div>
                <div class="modal-footer">
                    {!! Form::open(['method' => 'DELETE', 'route' => ['admin.backgrounds.destroy', ''], 'id' => 'delete-background', 'class' => 'inline-block']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <table id="DataTable" class="table table-default table-hover table-responsive display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($backgrounds as $background)
                <tr>
                    <td><img src="{!! asset('/images/backgrounds/'.$background->name) !!}" width="250px" alt=""/></td>
                    <td>
                        <button class="btn btn-danger delete_background" title="Delete" data-id="{!! $background->id !!}" data-toggle="modal" data-target="#DeleteBackgroundModal">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script type="text/javascript" src="{!! asset('/assets/js/DataTable.js') !!}"></script>

    <script type="text/javascript">
        $( document ).ready(function() {

            $('#DataTable').DataTable();

            var action = $("#delete-background").attr('action');

            $( "body" ).delegate( ".delete_background", "click", function() {
                var data_id = $(this).attr('data-id');
                var url = action+'/'+data_id;
                $("#delete-background").attr('action', url);
            });

        });
    </script>

@endsection