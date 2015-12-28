@extends('layouts.master')

@section('content')
    <div class="row">
        @if(session('error'))
            <div class="alert alert-danger">
                <ul>
                    <li>{!! session('error') !!}</li>
                </ul>
            </div>
        @elseif(session('message'))
            <div class="alert alert-success">
                <ul>
                    <li> {!! session('message') !!}</li>
                </ul>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="panel panel-default" style="overflow-x: scroll;">
                <div class="form-panels">
                    <h5 class="subtitle mb5" style="margin:20px 10px;">Team Status</h5>
                    <hr>
                    <table class="table table-striped table-advance table-primary table-hover">
                        <thead>
                        <tr>
                            <th class="col-md-3"><i class="fa fa-bullhorn"></i> Name</th>
                            <th class="col-md-3"><i class="fa fa-question-circle"></i> Email</th>
                            <th class="col-md-3"><i class=" fa fa-edit"></i> Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{!! Auth::user()->name !!}</td>
                            <td>{!! Auth::user()->email !!}</td>
                            <td><span class="label label-success label-mini">You</span></td>
                        </tr>
                        @if(isset($team_members))
                            @foreach($team_members as $member)
                                @if($member->activation != 0)
                                    <tr>
                                        <td>{!! $member->name !!}</td>
                                        <td>{!! $member->email !!}</td>
                                        <td class="teams"><span class="label label-success label-mini"> Team Member </span></td>
                                    </tr>
                                @else
                                @endif
                            @endforeach
                        @endif
                        @if(isset($invited_members))
                            @foreach($invited_members as $member)
                                @if($member->status == 0)
                                    <tr>
                                        <td>Not Yet!</td>
                                        <td>{!! $member->accept_email !!}</td>
                                        <td class="inviteacc"><span class="label label-warning label-mini">Invitation Sent </span></td>
                                    </tr>
                                    @else
                                @endif
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @if(!Auth::user()->parent_user && Auth::user()->type != 4 )
            <div class="panel panel-default">
                <div class="form-panels">
                    <h5 class="subtitle mb5" style="margin:20px 10px;">Invite A New Member to your Team</h5>
                    <form action="{!! url('/team/invite') !!}" method="post" class="form-inline" role="form">
                        <input type="hidden" name="_token" id="csrf-token" value="{!! Session::token() !!}" />
                        <div class="form-group">
                            <label class="sr-only" for="Email">Email</label>
                            <input type="email" name="email" value="" placeholder="Email" class="form-control">
                        </div>
                        <input type="submit" value="Invite To Team" class="btn btn-theme">
                    </form>
                </div>
            </div>
        @endif
    </div>


@endsection