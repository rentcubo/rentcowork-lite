<?php

 
Route::group(['middleware' => 'web'], function() {

    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function() {

        Route::get('/clear-cache', function() {

            $exitCode = Artisan::call('config:cache');

            return back();

        })->name('clear-cache');

        Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('login');

        Route::post('login', 'Auth\AdminLoginController@login')->name('login.post');

        Route::post('logout', 'Auth\AdminLoginController@logout')->name('logout');


        //Account management

        Route::get('profile', 'AdminController@profile')->name('profile');

        Route::post('profile/save', 'AdminController@profile_save')->name('profile.save');

        Route::post('change/password', 'AdminController@change_password')->name('change.password');

        //dashboard

        Route::get('/', 'AdminController@dashboard')->name('dashboard');

        //users CRUD routes

        Route::get('users/index', 'AdminController@users_index')->name('users.index');

        Route::get('users/create', 'AdminController@users_create')->name('users.create');

        Route::get('users/edit', 'AdminController@users_edit')->name('users.edit');    

        Route::post('users/save', 'AdminController@users_save')->name('users.save');

        Route::get('users/view', 'AdminController@users_view')->name('users.view');

        Route::get('users/delete', 'AdminController@users_delete')->name('users.delete');

        Route::get('users/status', 'AdminController@users_status')->name('users.status');

        Route::get('users/review','AdminController@users_review')->name('users.review');

        //provider CRUD routes

        Route::get('providers/index', 'AdminController@providers_index')->name('providers.index');

        Route::get('providers/create', 'AdminController@providers_create')->name('providers.create');

        Route::get('providers/edit', 'AdminController@providers_edit')->name('providers.edit');

        Route::post('providers/save', 'AdminController@providers_save')->name('providers.save');

        Route::get('providers/view/', 'AdminController@providers_view')->name('providers.view');

        Route::get('providers/delete', 'AdminController@providers_delete')->name('providers.delete');

        Route::get('providers/status', 'AdminController@providers_status')->name('providers.status');

        Route::get('providers/review','AdminController@providers_review')->name('providers.review');

        
        // Static page CRUD routes

        Route::get('static_pages' , 'AdminController@static_pages_index')->name('static_pages.index');

        Route::get('static_pages/create', 'AdminController@static_pages_create')->name('static_pages.create');

        Route::get('static_pages/edit', 'AdminController@static_pages_edit')->name('static_pages.edit');

        Route::post('static_pages/save', 'AdminController@static_pages_save')->name('static_pages.save');

        Route::get('static_pages/delete', 'AdminController@static_pages_delete')->name('static_pages.delete');

        Route::get('static_pages/view', 'AdminController@static_pages_view')->name('static_pages.view');

        Route::get('static_pages/status', 'AdminController@static_pages_status_change')->name('static_pages.status');


        //spaces CRUD routes

        Route::get('spaces/index', 'AdminController@spaces_index')->name('spaces.index');

        Route::get('spaces/create', 'AdminController@spaces_create')->name('spaces.create');

        Route::get('spaces/edit', 'AdminController@spaces_edit')->name('spaces.edit');    

        Route::post('spaces/save', 'AdminController@spaces_save')->name('spaces.save');

        Route::get('spaces/view', 'AdminController@spaces_view')->name('spaces.view');

        Route::get('spaces/delete', 'AdminController@spaces_delete')->name('spaces.delete');

        Route::get('spaces/status', 'AdminController@spaces_status')->name('spaces.status');

        //Booking Management routes

        Route::get('bookings/index','AdminController@bookings_index')->name('bookings.index');

        Route::get('bookings/view','AdminController@bookings_view')->name('bookings.view');
        Route::get('bookings/payment','AdminController@bookings_payments')->name('bookings.payment');

        Route::get('bookings/payment/view','AdminController@bookings_payments_view')->name('bookings.payments.view');
        //Setting Management
        Route::get('settings' , 'AdminController@settings')->name('settings');
    
        Route::post('settings' , 'AdminController@settings_save')->name('settings.save');

        Route::post('common-settings_save' , 'AdminController@common_settings_save')->name('common-settings.save');
        

    }); 

});
