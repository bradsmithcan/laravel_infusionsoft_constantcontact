@extends('layouts.master')

@section('content')
    <div class="modal fade" id="mailchimp" tabindex="-1" role="dialog" aria-labelledby="mailchimpLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="mailchimpLabel">MailChimp</h4>
                </div>
                @if(isset($data[1])) {!! Form::model($data[1],['method' => 'PATCH','route'=>['emailservice.update',$data[1]['id']]]) !!} @else <form action="{!! url('/emailservice/add') !!}" method="post"> @endif

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="i_mailchimp">API Key</label>
                            <input type="text" class="form-control" value="@if(isset($data[1])){!! $data[1]['thekey'] !!}@endif" id="i_mailchimp" name="thekey" placeholder="Enter your API Key">
                            <p class="help-block">Enter your MailChimp API Key</p>
                            <input type="text" class="form-control" value="@if(isset($data[1])){!! $data[1]['list'] !!}@endif" id="list_mailchimp" name="list" placeholder="Enter your List ID">
                            <p class="help-block">Enter your MailChimp List ID</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="api_id" value="1">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn @if(isset($data[1])) btn-warning @else btn-primary @endif" id="mailchimp_submit">@if(isset($data[1])) Update @else Submit @endif</button>
                    </div>
                    @if(isset($data[1])) {!! Form::close() !!} @else </form> @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="getresponse" tabindex="-1" role="dialog" aria-labelledby="getresponseLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="getresponseLabel">Get Response</h4>
                </div>
                @if(isset($data[2])) {!! Form::model($data[2],['method' => 'PATCH','route'=>['emailservice.update',$data[2]['id']]]) !!} @else  <form action="{!! url('/emailservice/add') !!}" method="post"> @endif
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="i_gp">API Key</label>
                            <input type="text" class="form-control"  value="@if(isset($data[2])){!! $data[2]['thekey'] !!}@endif" id="i_gp" name="thekey" placeholder="Enter your API Key" required>
                            <p class="help-block">Enter your Get Response API Key</p>
                            <label for="compaign_id">Compaign ID</label>
                            <input type="text" class="form-control"  value="@if(isset($data[2])){!! $data[2]['compaign_id'] !!}@endif" id="compaign_id" name="compaign_id" placeholder="Enter your Compaign ID" required>
                            <p class="help-block">Enter your Get Response Compaign ID</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="api_id" value="2">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="gp_submit" class="btn @if(isset($data[2])) btn-warning @else btn-primary @endif ">@if(isset($data[2])) Update @else Submit @endif</button>
                    </div>
                    @if(isset($data[2])) {!! Form::close() !!} @else  </form> @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="icontact" tabindex="-1" role="dialog" aria-labelledby="icontactLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="icontactLabel">iContact</h4>
                </div>
                @if(isset($data[3])) {!! Form::model($data[3],['method' => 'PATCH','route'=>['emailservice.update',$data[3]['id']]]) !!} @else  <form action="{!! url('/emailservice/add') !!}" method="post"> @endif
                    <div class="modal-body">
                        <p>To start using iContact, please add the UserGrow Application to your account by visiting iContact
                            <a href="https://app.icontact.com/icp/core/externallogin" target="_blank">here</a>.
                            Under "Allow another External Program to Access Your Account," enter "<strong>ueYqJLwrC0vfM5YGpkxycSAxecgXlDGy</strong>"
                            as the Application ID and then create a new password. Enter that password below.</p>
                        <div class="form-group">
                            <label for="i_pw">Application Password</label>
                            <input type="text" class="form-control"  value="@if(isset($data[3])){!! $data[3]['api_password'] !!}@endif" id="i_pw" name="api_password" placeholder="Enter Application Password" required>
                            <p class="help-block">Your iContact API Password that you set. This is <u>not</u> your iContact account password.</p>

                            <label for="api_username">Application Username</label>
                            <input type="text" class="form-control"  value="@if(isset($data[3])){!! $data[3]['api_username'] !!}@endif" id="api_username" name="api_username" placeholder="Enter Api Username" required>
                            <p class="help-block">Your iContact API </p>

                            <label for="app_id">App ID</label>
                            <input type="text" class="form-control"  value="@if(isset($data[3])){!! $data[3]['app_id'] !!}@endif" id="app_id" name="app_id" placeholder="Enter Application ID" required>
                            <p class="help-block">Your iContact API </p>

                            <label for="list">List ID</label>
                            <input type="text" class="form-control"  value="@if(isset($data[3])){!! $data[3]['list'] !!}@endif" id="list" name="list" placeholder="Enter List ID" required>
                            <p class="help-block">Your iContact API </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="api_id" value="3">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="pw_submit" class="btn  @if(isset($data[3])) btn-warning @else btn-primary @endif ">@if(isset($data[3])) Update @else Submit @endif</button>
                    </div>
                    @if(isset($data[3])) {!! Form::close() !!} @else  </form> @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="infusionsoft" tabindex="-1" role="dialog" aria-labelledby="infusionsoftLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="infusionsoftLabel">Infusionsoft</h4>
                </div>
                @if(isset($data[4])) {!! Form::model($data[4],['method' => 'PATCH','route'=>['emailservice.update',$data[4]->id]]) !!} @else  <form action="{!! url('/emailservice/add') !!}" method="post"> @endif
                    <div class="modal-body">
                        <p>To start using Infusionsoft, please generate your API Key by visiting your Infusionsoft Account Settings.
                            <a href="http://ug.infusionsoft.com/article/AA-00442/0/How-do-I-enable-the-Infusionsoft-API-and-generate-an-API-Key.html" target="_blank">
                                Get Step-by-Step Directions Here</a>.</p>
                        <div class="form-group">
                            <label for="i_infusionsoft">API Key</label>
                            <input type="text" class="form-control" id="i_infusionsoft"  value="@if(isset($data[4])){!! $data[4]['thekey'] !!}@endif" name="thekey" placeholder="Enter your API Key" required>
                            <p class="help-block">Your Infusionsoft API Key. You must create this at InfusionSoft.</p>
                        </div>

                        <div class="form-group">
                            <label for="i_infusionsoft_add">Account Name</label>
                            <input type="text" name="additional" id="i_infusionsoft_add"  value="@if(isset($data[4])){!! $data[4]['additional']['account_name'] !!}@endif" class="form-control" placeholder="InfusionSoft Account Name" required />
                            <p class="help-block">Your Infusionsoft Account Name. This is the URL where you login - it looks like "test.infusionsoft.com" with "test" being the account name.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="api_id" value="4">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="infusionsoft_submit" class="btn  @if(isset($data[4])) btn-warning @else btn-primary @endif ">@if(isset($data[4])) Update @else Submit @endif</button>
                    </div>
                    @if(isset($data[4])) {!! Form::close() !!} @else  </form> @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="madmimi" tabindex="-1" role="dialog" aria-labelledby="madmimiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="madmimiLabel">Madmimi</h4>
                </div>
                @if(isset($data[5])) {!! Form::model($data[5],['method' => 'PATCH','route'=>['emailservice.update',$data[5]['id']]]) !!} @else <form action="{!! url('/emailservice/add') !!}" method="post"> @endif
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="i_madmimi">API Key</label>
                            <input type="text" class="form-control"  value="@if(isset($data[5])){!! $data[5]['thekey'] !!}@endif" id="i_madmimi" name="thekey" placeholder="Enter your API Key" required>
                            <p class="help-block">Enter your Madmimi API Key</p>
                        </div>

                        <div class="form-group">
                            <label for="api_username">MadMimi Username</label>
                            <input type="text" class="form-control" id="api_username" value="@if(isset($data[5])){!! $data[5]['api_username'] !!}@endif" name="api_username" placeholder="Enter your Username/Email" required>
                            <p class="help-block">Your Madmimi Username</p>
                        </div>

                        <div class="form-group">
                            <label for="list">MadMimi List Name</label>
                            <input type="text" class="form-control" id="api_username" value="@if(isset($data[5])){!! $data[5]['list'] !!}@endif" name="list" placeholder="Enter your List Name" required>
                            <p class="help-block">Your List Name</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="api_id" value="5">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="submit" id="madmimi_submit" class="btn @if(isset($data[5])) btn-warning @else btn-primary @endif " value="@if(isset($data[5])) Update @else Submit @endif">
                    </div>
                    @if(isset($data[5])) {!! Form::close() !!} @else  </form> @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="aweber" tabindex="-1" role="dialog" aria-labelledby="aweberLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="aweberLabel">AWeber</h4>
                </div>
                @if(isset($data[6])) {!! Form::model($data[6],['method' => 'PATCH','route'=>['emailservice.update',$data[6]['id']]]) !!} @else  <form action="{!! url('/emailservice/add') !!}" method="post"> @endif
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="i_aweber">Authorization Code</label>
                            <input type="text" class="form-control" id="i_aweber" value="@if(isset($data[6])){!! $data[6]['additional']['code'] !!}@endif" name="additional[code]" placeholder="Enter the Authorization Code" required>
                            <p class="help-block">After clicking the above button and approving UserGrow to access your AWeber account, two codes will be shown. Copy & paste them here.</p>
                        </div>
                        <div class="form-group">
                            <label for="i_aweber_add">Consumer Key</label>
                            <input type="text" class="form-control" id="i_aweber_add" value="@if(isset($data[6])){!! $data[6]['additional']['consumerKey'] !!}@endif" name="additional[consumerKey]" placeholder="Enter the Consumer Key" required>
                            <p class="help-block">After clicking the above button and approving UserGrow to access your AWeber account, two codes will be shown. Copy & paste them here.</p>
                        </div>
                        <div class="form-group">
                            <label for="i_aweber_add">Consumer Secret</label>
                            <input type="text" class="form-control" id="i_aweber_add" value="@if(isset($data[6])){!! $data[6]['additional']['consumerSecret'] !!}@endif" name="additional[consumerSecret]" placeholder="Enter the Consumer Secret" required>
                            <p class="help-block">After clicking the above button and approving UserGrow to access your AWeber account, two codes will be shown. Copy & paste them here.</p>
                        </div>
                        <div class="form-group">
                            <label for="i_aweber_add">Account Id</label>
                            <input type="text" class="form-control" id="i_aweber_add" value="@if(isset($data[6])){!! $data[6]['additional']['accountId'] !!}@endif" name="additional[accountId]" placeholder="Enter the Account Id" required>
                            <p class="help-block">After clicking the above button and approving UserGrow to access your AWeber account, two codes will be shown. Copy & paste them here.</p>
                        </div>
                        <div class="form-group">
                            <label for="i_aweber_add">List Id</label>
                            <input type="text" class="form-control" id="i_aweber_add" value="@if(isset($data[6])){!! $data[6]['list'] !!}@endif" name="list" placeholder="Enter the List Id" required>
                            <p class="help-block">After clicking the above button and approving UserGrow to access your AWeber account, two codes will be shown. Copy & paste them here.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="api_id" value="6">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="submit" id="aweber_submit" class="btn @if(isset($data[6])) btn-warning @else btn-primary @endif " id="aweber_submit" value="@if(isset($data[6])) Update @else Submit @endif">

                    </div>
                    @if(isset($data[6])) {!! Form::close() !!} @else  </form> @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="cc" tabindex="-1" role="dialog" aria-labelledby="ccLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="ccLabel">Constant Contact</h4>
                </div>
                @if(isset($data[7])) {!! Form::model($data[7],['method' => 'PATCH','route'=>['emailservice.update',$data[7]['id']]]) !!} @else  <form action="{!! url('/emailservice/add') !!}" method="post"> @endif
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="i_cc">Api Key</label>
                            <input type="text" class="form-control" id="i_cc"  value="@if(isset($data[7])){!! $data[7]['thekey'] !!}@endif" name="thekey" placeholder="Enter the Api Key" required>
                            <p class="help-block">After clicking the above button and approving UserGrow to access your Constant Contact account, a code will be shown. Copy & paste it here.</p>

                            <label for="i_cc">Access Token</label>
                            <input type="text" class="form-control" id="i_cc"  value="@if(isset($data[7])){!! $data[7]['additional']['access_token'] !!}@endif" name="additional[access_token]" placeholder="Enter the Access Token" required>
                            <p class="help-block">After clicking the above button and approving UserGrow to access your Constant Contact account, a code will be shown. Copy & paste it here.</p>

                            <label for="i_cc">List Id</label>
                            <input type="text" class="form-control" id="i_cc"  value="@if(isset($data[7])){!! $data[7]['list'] !!}@endif" name="list" placeholder="Enter the List Id" required>
                            <p class="help-block">After clicking the above button and approving UserGrow to access your Constant Contact account, a code will be shown. Copy & paste it here.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="api_id" value="7">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="submit" id="cc_submit" class="btn @if(isset($data[7])) btn-warning @else btn-primary @endif " name="cc" value="@if(isset($data[7])) Update @else Submit @endif"/>
                    </div>
                    @if(isset($data[7])) {!! Form::close() !!} @else </form> @endif
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#mailchimp_submit').click(function(e){
            if(! $('#i_mailchimp').val()){
                return false;
            }
        });

        $('#gp_submit').click(function(e){
            if(! $('#i_gp').val()){
                return false;
            }
        });

        $('#pw_submit').click(function(e){
            if(! $('#i_pw').val()){
                return false;
            }
        });

        $('#infusionsoft_submit').click(function(e){
            if(!$('#i_infusionsoft').val() || !$('#i_infusionsoft_add').val()){
                return false;
            }
        });

//        $('#madmimi_submit').click(function(e){
//            if(!$('#i_madmimi').val() || !$('#i_madmimi_add').val()){
//                return false;
//            }
//        });

        $('#aweber_submit').click(function(e){
            if(!$('#i_aweber').val() || !$('#i_aweber_add').val()){
                return false;
            }
        });

        $('#cc_submit').click(function(e){
            if(! $('#i_cc').val()){
                return false;
            }
        });
    </script>

    <h2>Email Service</h2>
    <div class="row">
        <hr>

        @if(session('message'))
            <div class="alert alert-success">
                {!! session('message') !!}
            </div>
        @endif
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr class="bg-info">
                <th>Email Service</th>
                <th colspan="1">Actions</th>
                <th></th>
            </tr>
            </thead>
            <tfoot>
            <tr class="bg-info">
                <th>Email Service</th>
                <th colspan="1">Actions</th>
                <th></th>
            </tr>
            </tfoot>
            <tbody>

                <tr>
                    <td>MailChimp</td>
                    <td><button class="btn @if(isset($data[1])) btn-warning @else btn-default @endif btn-sm" data-toggle="modal" data-target="#mailchimp"> @if(isset($data[1])) Change @else Start @endif </button></td>
                   		<td>
                        @if(isset($data[1]->id))
                            {!! Form::open(['method' => 'DELETE', 'route'=>['emailservice.destroy', $data[1]->id]]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
						</td>
                </tr>
                <tr>
                    <td>GetResponse</td>
                    <td><button class="btn @if(isset($data[2])) btn-warning @else btn-default @endif btn-sm" data-toggle="modal" data-target="#getresponse"> @if(isset($data[2])) Change @else Start @endif</button></td>
                    <td>
                        @if(isset($data[2]->id))
                            {!! Form::open(['method' => 'DELETE', 'route'=>['emailservice.destroy', $data[2]->id]]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>iContact</td>
                    <td><button class="btn @if(isset($data[3])) btn-warning @else btn-default @endif btn-sm" data-toggle="modal" data-target="#icontact"> @if(isset($data[3])) Change @else Start @endif</button></td>
                    <td>
                        @if(isset($data[3]->id))
                            {!! Form::open(['method' => 'DELETE', 'route'=>['emailservice.destroy', $data[3]->id]]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Infusionsoft</td>
                    <td><button class="btn @if(isset($data[4])) btn-warning @else btn-default @endif btn-sm" data-toggle="modal" data-target="#infusionsoft"> @if(isset($data[4])) Change @else Start @endif</button></td>
                    <td>
                        @if(isset($data[4]->id))
                            {!! Form::open(['method' => 'DELETE', 'route'=>['emailservice.destroy', $data[4]->id]]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Madmimi</td>
                    <td><button class="btn @if(isset($data[5])) btn-warning @else btn-default @endif btn-sm" data-toggle="modal" data-target="#madmimi"> @if(isset($data[5])) Change @else Start @endif</button></td>
                    <td>
                        @if(isset($data[5]->id))
                            {!! Form::open(['method' => 'DELETE', 'route'=>['emailservice.destroy', $data[5]->id]]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>AWeber</td>
                    <td><button class="btn @if(isset($data[6])) btn-warning @else btn-default @endif btn-sm" id="doaweber" data-toggle="modal" data-target="#aweber"> @if(isset($data[6])) Change @else Start @endif</button></td>
                    <td>
                        @if(isset($data[6]->id))
                            {!! Form::open(['method' => 'DELETE', 'route'=>['emailservice.destroy', $data[6]->id]]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Constant Contact</td>
                    <td><button class="btn @if(isset($data[7])) btn-warning @else btn-default @endif btn-sm" id="docc" data-toggle="modal" data-target="#cc"> @if(isset($data[7])) Change @else Start @endif</button></td>
                    <td>
                        @if(isset($data[7]->id))
                       
                            {!! Form::open(['method' => 'DELETE', 'route'=>['emailservice.destroy', $data[7]->id]]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                       
                        @endif
                        </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection