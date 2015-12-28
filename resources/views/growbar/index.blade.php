@extends('layouts.master')

@section('content')

    <link rel="stylesheet" href="{!! asset('/assets/css/DataTable.css') !!}">

    <div id="LinkModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">GrowBar</h4>
                </div>
                <div class="modal-body">
                    <a href="" id="modal-link" target="_blank"></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="DeleteGrowBarModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete GrowBar</h4>
                </div>
                <div class="modal-body">
                    <div>Please confirm DELETE.</div>
                </div>
                <div class="modal-footer">
                    {!! Form::open(['method' => 'DELETE', 'route' => ['growbar.destroy', ''], 'id' => 'delete-growbar', 'class' => 'inline-block']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

         </div>
    </div>

    @if(session('growbar'))
        <div class="alert alert-success">
            {!! url('api/scripts/').'/'.session('growbar').'.js' !!}
        </div>

    @endif
    <table id="DataTable" class="table table-default table-hover table-responsive display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Headline</th>
                <th>WebSite</th>
                <th>Views</th>
                <th>Conversion</th>
                <th>%</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($growBars as $growBar)
                <tr>
                    <td>{!! $growBar->headline !!}</td>
                    <td>{!! $growBar->website !!}</td>
                    <td>{!! $growBar->views !!}</td>
                    <td>{!! $growBar->conversion !!}</td>
                    <td>{!! $growBar->views !!}</td>
                    <td>
                        <button class="btn btn-primary get_link" title="Get Short Link" data-link="{!! url('api/scripts/').'/'.$growBar->hash.'.js'  !!}" data-toggle="modal" data-target="#LinkModal">
                            <i class="fa fa-file-code-o"></i>
                        </button>
                        <a href="{!! route('growbar.edit',$growBar->id) !!}">
                            <button class="btn btn-primary" title="Edit" data-toggle="modal">
                                <i class="fa fa-edit"></i>
                            </button>
                        </a>
                        <button class="btn btn-danger delete_growbar" title="Delete" data-id="{!! $growBar->id !!}" data-toggle="modal" data-target="#DeleteGrowBarModal">
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

            var action = $("#delete-growbar").attr('action');

            $( "body" ).delegate( ".get_link", "click", function() {
                var data_link = $(this).attr('data-link');
                $("#modal-link").attr('href', data_link).html(data_link);
            });

            $( "body" ).delegate( ".delete_growbar", "click", function() {
                var data_id = $(this).attr('data-id');
                $("#delete-growbar").attr('action', action+'/'+data_id);
            });

        });
    </script>

@endsection