<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::model('contacts', 'Contact');
Route::model('emails', 'Email');
Route::model('phones', 'Phone');


Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::bind('emails', function($value, $route) {
	return App\Email::whereId($value)->first();
});

Route::bind('phones', function($value, $route) {
	return App\Phone::whereId($value)->first();
});

Route::bind('contacts', function($value, $route) {
	return App\Contact::whereId($value)->first();
});


Route::resource('contacts', 'ContactsController');
Route::resource('contacts.emails', 'EmailsController');
Route::resource('contacts.phones', 'PhonesController');

Route::resource('loadSpreadsheet', 'ContactsController@loadSpreadsheet');
Route::post('importSpreadsheet', array('as' => 'importSpreadsheet', 'uses' => 'ContactsController@importSpreadsheet'));