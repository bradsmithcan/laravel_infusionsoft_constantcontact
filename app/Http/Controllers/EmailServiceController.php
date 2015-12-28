<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Api;
use Illuminate\Support\Facades\Auth;
use App\Models\UserService;
use App\Models\ReLinkSnips;

use Mailchimp;
use GetResponse;
use iContact\iContactApi;
use AWeberAPI;
use Ctct\ConstantContact;
use Ctct\Components\Contacts\Contact;
use Ctct\Auth\CtctOAuth2;
use MadMimi;
use Infusionsoft;
use Infusionsoft\Api\ContactService;

class EmailServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apis = Api::all();
        $emailServices = UserService::where(['user_id'=> Auth::user()->id])->get();
        $data = [];
        foreach($emailServices as $emailService ){
            $emailService['additional'] = json_decode($emailService['additional'], 1);
            $data[$emailService->api_id] = $emailService;
        }
        return view('emailservice.index', compact('apis', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service = UserService::find($id);

        if($request['api_id'] == 1)
        {
            $rules = [
                'thekey'=> 'required',
                'list'=> 'required'
            ];
        }
        elseif($request['api_id'] == 2)
        {
            $rules = [
                'thekey'=> 'required',
                'compaign_id'=> 'required'
            ];
        }
        elseif($request['api_id'] == 3)
        {
            $rules = [
                'list'=> 'required',
                'app_id'=> 'required',
                'api_username'=> 'required',
                'api_password'=> 'required'
            ];
        }
        elseif($request['api_id'] == 5)
        {
            $rules = [
                'thekey'=> 'required',
                'api_username'=> 'required',
                'list'=> 'required'
            ];
        }
        elseif($request['api_id'] == 6)
        {
            $rules = [
                'additional.code'=> 'required',
                'additional.consumerKey'=> 'required',
                'additional.consumerSecret'=> 'required',
                'additional.accountId'=> 'required',
                'list'=> 'required'
            ];
        }
        elseif($request['api_id'] == 7)
        {
            $rules = [
                'thekey'=> 'required',
                'additional.access_token'=> 'required',
                'list'=> 'required'
            ];
        }
        $this->validate($request, $rules);
        $request['additional'] = json_encode($request['additional']);

        $service->update($request->all());
        return redirect('emailservice');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $service = UserService::find($id);
        $service->delete();
        $request->session()->flash('message', "Email service settings removed successfully.");
        return redirect('emailservice');
    }

    public function add(Request $request)
    {
        $data = $request->all();

        if($data['api_id'] == 1)
        {
            $rules = [
                'thekey'=> 'required',
                'list'=> 'required'
            ];
        }
        elseif($data['api_id'] == 2)
        {
            $rules = [
                'thekey'=> 'required',
                'compaign_id'=> 'required'
            ];
        }
        elseif($data['api_id'] == 3)
        {
            $rules = [
                'list'=> 'required',
                'app_id'=> 'required',
                'api_username'=> 'required',
                'api_password'=> 'required'
            ];
        }
        elseif($data['api_id'] == 5)
        {
            $rules = [
                'thekey'=> 'required',
                'api_username'=> 'required',
                'list'=> 'required'
            ];
        }
        elseif($data['api_id'] == 6)
        {
            $rules = [
                'additional.code'=> 'required',
                'additional.consumerKey'=> 'required',
                'additional.consumerSecret'=> 'required',
                'additional.accountId'=> 'required',
                'list'=> 'required'
            ];
        }
        elseif($data['api_id'] == 7)
        {
            $rules = [
                'thekey'=> 'required',
                'additional.access_token'=> 'required',
                'list'=> 'required'
            ];
        }

        $this->validate($request, $rules);

        $data['user_id'] = Auth::user()->id;
        if($data['api_id'] == 6)
        {
            $access = $this->getAweberAccess($data['additional']['code']);
            $data['additional']['accessKey'] = $access['accessKey'];
            $data['additional']['accessSecret'] = $access['accessSecret'];
        }

        $data['additional'] = json_encode($data['additional']);

        UserService::create($data);
        $request->session()->flash('message', "Email service settings added successfully.");
        return redirect('emailservice');
    }

    public function mailchimp($service, $email)
    {
        $apikey = $service->thekey;
        $listId = $service->list;

        $MailChimp = new Mailchimp($apikey);

        $MailChimp->lists->subscribe(
            $listId,
            array('email'=>$email),
            null,
            false,
            true,
            false,
            false
        );

       echo "ok";die;
    }

    public function getresponse($service, $email)
    {
        $apikey = $service->thekey;
        $compaignId = $service->compaign_id;

        $getresponse = new GetResponse($apikey);

        $getresponse->addContact(array(
                'name'              => 'User',
                'email'             => $email,
                'dayOfCycle'        => 0,
                'campaign'          => array('campaignId' => $compaignId)
            )
        );

        echo "ok";die;
    }

    public function icontact($service, $email)
    {
        $appId = $service->app_id;
        $api_password = $service->api_password;
        $api_username = $service->api_username;
        $listId = $service->list;

        iContactApi::getInstance()->setConfig(array(
            'appId'       => $appId,
            'apiPassword' => $api_password,
            'apiUsername' => $api_username
        ));

        // Store the singleton
        $iContact = iContactApi::getInstance();

        $contact = $iContact->addContact($email, null);
        $iContact->subscribeContactToList($contact->contactId, $listId, 'normal');

        echo "ok";die;
    }

    public function getAweberAccess($authorization_code)
    {
        $auth = AWeberAPI::getDataFromAweberID($authorization_code);

        list($consumerKey, $consumerSecret, $accessKey, $accessSecret) = $auth;

        return compact('accessKey', 'accessSecret');
    }

    public function aweber($service, $email)
    {
        $service['additional'] = json_decode($service['additional'], 1);

        $consumerKey = $service['additional']['consumerKey'];
        $consumerSecret = $service['additional']['consumerSecret'];
        $accessKey = $service['additional']['accessKey'];
        $accessSecret = $service['additional']['accessSecret'];
        $accountId = $service['additional']['accountId'];
        $listId = $service['list'];

        $aweber = new AWeberAPI($consumerKey, $consumerSecret);

        $account = $aweber->getAccount($accessKey, $accessSecret);

        $listURL = "/accounts/{$accountId}/lists/{$listId}";

        $list = $account->loadFromUrl($listURL);

        $params = array(
            'email' => $email
        );
        $subscribers = $list->subscribers;

        try{
            $subscribers->create($params);

            echo "ok";die;
        }
        finally {
            echo "ok";die;
        }
    }

    public function constantcontact($service, $email)
    {
        $apikey = $service['thekey'];
        $service['additional'] = json_decode($service['additional'], 1);

        $access_token = $service['additional']['access_token'];
        $listId = $service['list'];

        $cc = new ConstantContact($apikey);

        $contact = new Contact();
        $contact->addEmail($email);
        $contact->addList($listId);
        $contact->status = 'ACTIVE';

        $cc->contactService->addContact($access_token, $contact);

        echo "ok";die;
    }

    public function madmimi($service, $email)
    {
        $apiKey = $service->thekey;
        $username = $service->api_username;
        $list_name = $service->list;

        $mailer = new MadMimi($username, $apiKey);

        $user = array(
            'email' => $email,
            'add_list' => $list_name
        );

        $mailer->AddUser($user);

        echo "ok";die;
    }

    public function infusionsoft()
    {
        $key = 'gqaj3tc8k7nxvb54tydc76cr';
        $secret = '2q8FexUnKK';

        $clientId = 'annh.odesk@gmail.com';
        $clientSecret = '2q8FexUnKK';
        $redirectUri = 'https://www.google.com';

        $infusionsoft = new Infusionsoft(array(
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => $redirectUri,
            'debug' => true,
        ));

        $newContact = new ContactService($infusionsoft);
dd($infusionsoft->contacts);
        $n = $infusionsoft->contacts->add(array('FirstName' => 'John', 'LastName' => 'Doe'));
        dd($n);
    }

    public function subscribe(Request $request)
    {
        $data = $request->all();

        $rules = [
          'growpage' => 'required|exists:relink_snips,id'
        ];

        $this->validate($request, $rules);

        $growPage_item = ReLinkSnips::find($data['growpage']);
        $api = Api::find($growPage_item['api']);

        $service = UserService::where(['user_id' => $growPage_item['user_id'],'api_id' => $growPage_item['api']])->first();

        $name = str_replace(' ', '', strtolower($api->name));

        $this->$name($service, $data['email']);

    }

}