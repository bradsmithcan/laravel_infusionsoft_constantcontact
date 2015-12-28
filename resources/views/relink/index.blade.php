@extends('layouts.master')

@section('content')

    <link rel="stylesheet" href="{!! asset('/assets/css/DataTable.css') !!}">

    <div id="ShortLinkModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Link</h4>
                </div>
                <div class="modal-body">
                    <a href="" target="_blank" id="modal-shortLink"></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="EditReLinkModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Link</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method' => 'PATCH', 'route' => ['relink.update', ''], 'id' => 'edit-relink', 'class' => 'inline-block']) !!}

                        <div class="col-xs-12">
                            {!! Form::label('title', 'Link Title') !!}
                        </div>
                        <div class="col-xs-12">
                            {!! Form::text('title', '', ['placeholder' => 'Reference Name','id' => 'edit-title', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-xs-12">
                            {!! Form::label('redirect_url', 'Redirect URL', ['class' => 'text-align-left']) !!}
                        </div>
                        <div class="col-xs-12" id="url_section">
                            {!! Form::url('redirect_url', '', ['placeholder' => 'http://yourtargeturl.com','id' => 'edit-redirect-url', 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                {!! Form::label('code', 'Retargeting Pixel/Code', ['class' => 'text-align-left']) !!}
                            </div>
                            <div class="col-xs-12">
                                {!! Form::textarea('code', '', ['placeholder' => 'Reference Name','id' => 'edit-code', 'rows' => '5','class' => 'form-control']) !!}
                            </div>
                        </div>

                </div>
                <div class="modal-footer">

                        {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="DeleteReLinkModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Link</h4>
                </div>
                <div class="modal-body">
                    <div>Please confirm DELETE.</div>
                </div>
                <div class="modal-footer">
                    {!! Form::open(['method' => 'DELETE', 'route' => ['relink.destroy', ''], 'id' => 'delete-relink', 'class' => 'inline-block']) !!}
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
                <th>Title</th>
                <th>Target URL</th>
                <th>Clicks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($relinks as $relink)
                <tr>
                    <td>{!! $relink->title !!}</td>
                    <td>{!! $relink->redirect_url !!}</td>
                    <td>{!! count($relink->reLinkClicks) !!}</td>
                    <td>
                        <button class="btn btn-primary get_short_link" title="Get Short Link" data-shortLink="{!! $relink->short_link !!}" data-toggle="modal" data-target="#ShortLinkModal">
                            <i class="fa fa-file-code-o"></i>
                        </button>
                        <button class="btn btn-primary edit_re_link" title="Edit" data-id="{!! $relink->id !!}" data-title="{!! $relink->title !!}" data-redirect-url="{!! $relink->redirect_url !!}" data-code="{!! $relink->code !!}" data-toggle="modal" data-target="#EditReLinkModal">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger delete_link" title="Delete" data-id="{!! $relink->id !!}" data-toggle="modal" data-target="#DeleteReLinkModal">
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

            $( "body" ).delegate( ".get_short_link", "click", function() {
                var data_shortLink = $(this).attr('data-shortLink');
                $("#modal-shortLink").attr('href', data_shortLink).html(data_shortLink);
            });

            var action = $("#delete-relink").attr('action');

            $( "body" ).delegate( ".edit_re_link", "click", function() {
                var id = $(this).attr('data-id');
                var title = $(this).attr('data-title');
                var redirect_url = $(this).attr('data-redirect-url');
                var code = $(this).attr('data-code');

                $("#edit-title").val(title);
                $("#edit-redirect-url").val(redirect_url);
                $("#edit-code").val(code);

                var data_id = $(this).attr('data-id');
                $("#edit-relink").attr('action', action+'/'+data_id);
            });

            $( "body" ).delegate( ".delete_link", "click", function() {
                var data_id = $(this).attr('data-id');
                $("#delete-relink").attr('action', action+'/'+data_id);
            });

        });
    </script>

@endsection