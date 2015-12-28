<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Utilities\Infusion;
use App\Models\Plan;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Infusionsoft_App;
use Infusionsoft_AppPool;
use Infusionsoft_Contact;
use Infusionsoft_DataService;
use Infusionsoft_OAuth2;

require_once '../vendor/novaksolutions/infusionsoft-php-sdk/Infusionsoft/infusionsoft.php';

class UserController extends Controller
{
    /**
     * User instance.
     *
     * @var User
     */
    protected $user;

    /**
     * Infusionsoft utility Instance.
     *
     * @var Infusion
     */
    protected $infusion;

    /**
     * Infusion connection.
     *
     * @var resource
     */
    protected $app;


    /**
     * Authorization link for infusionsoft.
     *
     * @var string
     */
    protected $auth_link;


    /**
     * Create User and Infusion instance.
     *
     * @internal param Infusion $infusion
     * @internal param Infusion $infusion
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function connect(Infusion $infusion)
    {
        $infusion->addApp();
        $infusion->credentials();
        $infusion->oAuth();
        die();
    }

    /**
     * Display userinfo from infusionsoft contact.
     *
     * @param Infusion $infusion
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     * @internal param Infusion $infusion
     * @internal param Request $request
     * @internal param Request $request
     */
    public function index(Infusion $infusion)
    {
        $this->connect($infusion);
    }

    /**
     * Show the form for editing the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     * @internal param int $id
     */
    public function edit(Request $request)
    {
        if ($request->session()->has('contact')) {
            $contact = $request->session()->get('contact');
            return view('settings.user.edit', ['user' => $this->user, 'contact' => $contact]);
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Infusion $infusion
     * @param UpdateUserRequest|Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Infusion $infusion, Request $request)
    {
        $infusion->credentials();

        //When this is called, it will process the authentication response,
        //convert the OAuth2 GET params to your access and refresh tokens.
        //And then save them.
        Infusionsoft_OAuth2::processAuthenticationResponseIfPresent();


        //If you don't specify a hostname, connect() will load the hostname automatically from the saved file.
        //Note, this library does support multiple apps, so, if you authenticate to more then one app,
        //you really should specify the app to connect to.
        $this->app = Infusionsoft_App::connect();

        //If We Just Got Back From The OAuth Page...
        if (!$this->app->hasTokens()) {
            $infusion->oAuth();
            die();
        }

        $contact = $this->getContact(7);
        $contact->FirstName = $request->get('firstName');
        $contact->LastName = $request->get('secondName');
        $contact->Email = $request->get('email');
        $contact->save();
        $request->session()->put('contact', $contact->toArray());
//        dd($contact);

//        $this->user->update($request->all());
        return back();
    }

    /**
     * After successful call to infusionsoft data returns here.
     *
     * @param Infusion $infusion
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @internal param Request $request
     * @internal param Test $test
     */
    public function infusion(Infusion $infusion, Request $request)
    {
        $infusion->credentials();

        //When this is called, it will process the authentication response,
        //convert the OAuth2 GET params to your access and refresh tokens.
        //And then save them.
        Infusionsoft_OAuth2::processAuthenticationResponseIfPresent();


        //If you don't specify a hostname, connect() will load the hostname automatically from the saved file.
        //Note, this library does support multiple apps, so, if you authenticate to more then one app,
        //you really should specify the app to connect to.
        $this->app = Infusionsoft_App::connect();

        //If We Just Got Back From The OAuth Page...
        if (!$this->app->hasTokens()) {
            $infusion->oAuth();
            die();
        }

        $contact = $this->getContact(7)->toArray();

        $id = $this->user->id;

        if (!$request->session()->has('contact')) {
            $request->session()->put('contact', $contact);
        }
        return redirect("settings/user/{$id}/edit");
    }

    public function getContact($id)
    {
       return new Infusionsoft_Contact($id);
    }

}
