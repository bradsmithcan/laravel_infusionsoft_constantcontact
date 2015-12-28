<?php

namespace App\Http\Utilities;

use Illuminate\Http\Request;
use Infusionsoft_App;
use Infusionsoft_AppPool;
use Infusionsoft_OAuth2;


class Infusion
{
    public function credentials()
    {
        Infusionsoft_OAuth2::$redirectUri = env('INFUSIONSOFT_REDIRECT_URL');
        Infusionsoft_OAuth2::$clientId = env('INFUSIONSOFT_CLIENT_ID');
        Infusionsoft_OAuth2::$clientSecret = env('INFUSIONSOFT_SECRET');
    }

    public function addApp()
    {
        Infusionsoft_AppPool::addApp(
            new Infusionsoft_App(env('INFUSIONSOFT_HOST'), env('INFUSIONSOFT_CLIENT_ID'), 443)
        );
    }

    public function oAuth()
    {
        header("Location: " . Infusionsoft_OAuth2::getAuthorizationUrl());//Send To OAuth Page...
    }
}