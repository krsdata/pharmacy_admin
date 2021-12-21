<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, auth-token');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Origin: *");

if (App::environment('prod')) {
    \URL::forceScheme('https');
}

Route::match(['post','get'], 'changePassword', 'UserController@changePassword');

Route::match(['post','get'], 'changePasswordToken', 'UserController@changePasswordToken');


Route::match(['post','get'], '/', function(){

    return Redirect::to('admin');

});

Route::match(['post','get'], '404', 'HomeController@page404');


Route::match(['post','get'], 'myAffiliate', 'HomeController@myAffiliate');


Route::match(
    ['post','get'],
    '/contactus',
    [
        'as'   => 'contactus',
        'uses' => 'HomeController@contactus',
    ]
);



Route::match(
    ['post','get'],
    '/aboutus',
    [
        'as'   => 'aboutus',
        'uses' => 'HomeController@aboutus',
    ]
);

Route::match(
    ['post','get'],
    '/topReferralUser',
    [
        'as'   => 'topReferralUser',
        'uses' => 'HomeController@topReferralUser',
    ]
);




Route::match(
    ['post','get'],
    '/{name}',
    [
        'as'   => 'contentspage',
        'uses' => 'HomeController@getPage',
    ]
);

