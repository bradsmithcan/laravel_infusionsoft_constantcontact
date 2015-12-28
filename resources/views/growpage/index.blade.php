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
                    <a href="" id="modal-shortLink" target="_blank"></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="DeleteGrowPageModal" class="modal fade" role="dialog">
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
                    {!! Form::open(['method' => 'DELETE', 'route' => ['growpage.destroy', ''], 'id' => 'delete-growpage', 'class' => 'inline-block']) !!}
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
                <th>Slide Down Title</th>
                <th>Page URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($growPages as $growPage)
                <tr>
                    <td>{!! $growPage->title !!}</td>
                    <td>{!! $growPage->page_url !!}</td>
                    <td>
                        <button class="btn btn-primary get_short_link" title="Get Short Link" data-shortLink="{!! $growPage->short_link !!}" data-toggle="modal" data-target="#ShortLinkModal">
                            <i class="fa fa-file-code-o"></i>
                        </button>
                        <a href="{{route('growpage.edit',$growPage->id)}}">
                            <button class="btn btn-primary" title="Edit" data-toggle="modal">
                                <i class="fa fa-edit"></i>
                            </button>
                        </a>
                        <a href="{{url('growpage/duplicate',$growPage->id)}}">
                            <button class="btn btn-primary" title="" data-toggle="modal">
                                <i class="fa fa-files-o"></i>
                            </button>
                        </a>
                        <a href="{{url('growpage/splitTest',$growPage->id)}}">
                            <button class="btn btn-primary" title="" data-toggle="modal">
                                <i class="fa fa-share-square-o"></i>
                            </button>
                        </a>
                        <button class="btn btn-danger delete_growpage" title="Delete" data-id="{!! $growPage->id !!}" data-toggle="modal" data-target="#DeleteGrowPageModal">
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

            var action = $("#delete-growpage").attr('action');

            $( "body" ).delegate( ".get_short_link", "click", function() {
                var data_shortLink = $(this).attr('data-shortLink');
                $("#modal-shortLink").attr('href', data_shortLink).html(data_shortLink);
            });

            $( "body" ).delegate( ".delete_growpage", "click", function() {
                var data_id = $(this).attr('data-id');
                $("#delete-growpage").attr('action', action+'/'+data_id);
            });

        });
    </script>

@endsection