<?php

get('api/scripts/{key}.js', 'GrowBarController@script');

Route::group(['middleware' => 'guest'], function () {
    get('/', 'WelcomeController@index');
    get('invite/{code}', 'TeamController@acceptInvitation');
    get('activate/{code}', 'Auth\AuthController@activateAccount');
    post('resendEmail', 'Auth\AuthController@resendEmail');
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);

Route::post('/upload', 'MediaUploader@upload');
Route::post('/subscribe', 'EmailServiceController@subscribe');
Route::get('/getAweberAccessToken', 'EmailServiceController@getAweberAccessToken');

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'notchild'],  function () {

        Route::any('infusion', 'UserController@infusion');

        Route::group(['prefix' => 'settings'],  function () {
            Route::resource('user', 'UserController', ['except' => ['show', 'create', 'store', 'destroy']]);
        });

        Route::resource('profile', 'ProfileController');
        Route::resource('emailservice', 'EmailServiceController');
        Route::post('emailservice/add', 'EmailServiceController@add');

        Route::resource('relink', 'ReLinkController');
        Route::resource('growbar', 'GrowBarController');

        Route::resource('growpage', 'GrowPageController');
        get('growpage/duplicate/{id}', 'GrowPageController@duplicate');
        get('growpage/splitTest/{id}', 'GrowPageController@splitTest');
        get('short-link', 'ReLinkController@show_relink');
        get('r/{path}', 'ReLinkController@redirect_relink');
        get('g/{path}', 'GrowPageController@redirect_relink');

        Route::resource('team', 'TeamController');
        post('team/invite', 'TeamController@invite');
    });

    get('home', 'HomeController@index');

    Route::any('growpage/upload-image', 'GrowPageController@uploadImage');
    Route::any('upload-image', 'GrowPageController@uploadImage');

    Route::post('growpage/remove', 'GrowPageController@removeImage');


    Route::resource('link', 'LinkController');
    Route::any('links/system', 'LinkController@ajaxUrlChecking');

    Route::any('link/checkShortLink', ['as' => 'link.ajaxCheckShortLink', 'uses' => 'LinkController@ajaxCheckShortLink']);
//    Route::post('link', 'LinkController@store');

    Route::resource('profile', 'ProfileController',
        ['only' => ['index', 'show', 'edit', 'update']]);

    Route::resource('team', 'TeamController',
        ['only' => ['index']]);


    get('mailchimp', 'EmailServiceController@mailChip');
    get('getresponse', 'EmailServiceController@getResponse');
    get('icontact', 'EmailServiceController@iContact');
    get('aweber', 'EmailServiceController@aweber');
    get('constantcontact', 'EmailServiceController@constantcontact');
    get('madmimi', 'EmailServiceController@madmimi');
    get('infusionsoft', 'EmailServiceController@infusionsoft');

});

Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'],  function () {
    Route::resource('user', 'UserController');
    get('user/suspend/{id}', 'UserController@suspend');
    get('user/unsuspend/{id}', 'UserController@unsuspend');
    get('user/upgrade/{id}', 'UserController@upgrade');
    get('user/downgrade/{id}', 'UserController@downgrade');
    Route::resource('backgrounds', 'BackgroundController');
    Route::resource('domain', 'DomainController');
});
