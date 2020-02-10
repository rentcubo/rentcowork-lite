<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceUser within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'UserController@spaces_index')->name('spaces.index');

/***
 *
 * Profile management
 *
 */       

Route::get('profile_view', 'UserController@profile_view')->name('profile.view');

Route::get('profile_edit', 'UserController@profile_edit')->name('profile.edit');

Route::post('profile_save', 'UserController@profile_update')->name('profile.update');

Route::get('account_password_check', 'UserController@password_check')->name('password.check');

Route::post('account_delete','UserController@account_delete')->name('account.delete');

Route::get('change_password', 'UserController@change_password')->name('password.change');

Route::post('update_password', 'UserController@update_password')->name('password.save');

/***
 *
 * spaces management
 *
 */       
Route::get('spaces_index', 'UserController@spaces_index')->name('spaces.index');

Route::get('spaces_view', 'UserController@spaces_view')->name('spaces.view');

/***
 *
 * Booking management
 *
 */       
Route::get('bookings_index', 'UserController@bookings_index')->name('bookings.index');

Route::get('bookings_view', 'UserController@bookings_view')->name('bookings.view');

Route::post('bookings_save', 'UserController@bookings_save')->name('bookings.save');

Route::get('bookings_cancel', 'UserController@bookings_cancel')->name('bookings.cancel');

Route::get('bookings_payment', 'UserController@bookings_payment')->name('bookings.payment');

Route::get('bookings_checkin', 'UserController@bookings_checkin')->name('bookings.checkin');

Route::get('bookings_checkout', 'UserController@bookings_checkout')->name('bookings.checkout');

Route::post('bookings_review', 'UserController@bookings_review')->name('bookings.review');



/****
*
* Pages
* 
*/
Route::get('/page', 'UserController@pages')->name('pages');