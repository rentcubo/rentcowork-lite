<?php

 
Route::group(['middleware' => 'web'], function() {

    Route::group(['as' => 'provider.', 'prefix' => 'provider'], function() {

        Route::get('/clear-cache', function() {

            $exitCode = Artisan::call('config:cache');

            return back();

        })->name('clear-cache');

        Route::get('login', 'Auth\ProviderLoginController@showLoginForm')->name('login');

        Route::post('login', 'Auth\ProviderLoginController@login')->name('login.post');
        
        Route::get('register', 'Auth\ProviderRegisterController@showRegisterForm')->name('register');

        Route::post('register', 'Auth\ProviderRegisterController@register')->name('register.post');

        Route::post('logout', 'Auth\ProviderLoginController@logout')->name('logout');

        Route::get('/', 'ProviderController@dashboard')->name('dashboard');

         //password reset Routes
        Route::post('/password/email','Auth\ProviderForgotPasswordController@sendResetLinkEmail')->name('password.email');

        Route::get('/password/reset','Auth\ProviderForgotPasswordController@showLinkRequestForm')->name('password.request');

        Route::post('/password/reset','Auth\ProviderResetPasswordController@reset');

        Route::get('/password/reset/{token}','Auth\ProviderResetPasswordController@showResetForm')->name('password.reset');
        

        /***
         *
         * Profile management
         *
         */       

        Route::get('profile_view', 'ProviderController@profile_view')->name('profile.view');

        Route::get('profile_edit', 'ProviderController@profile_edit')->name('profile.edit');

        Route::post('profile_save', 'ProviderController@profile_update')->name('profile.update');

        Route::get('account_password_check', 'ProviderController@password_check')->name('password.check');
        
        Route::post('account_delete','ProviderController@account_delete')->name('account.delete');

        Route::get('change_password', 'ProviderController@change_password')->name('password.change');

        Route::post('update_password', 'ProviderController@update_password')->name('password.save');

        /***
         *
         * spaces management
         *
         */       
        Route::get('spaces_index', 'ProviderController@spaces_index')->name('spaces.index');

        Route::get('spaces_create', 'ProviderController@spaces_create')->name('spaces.create');

        Route::get('spaces_edit', 'ProviderController@spaces_edit')->name('spaces.edit');

        Route::post('spaces_save', 'ProviderController@spaces_save')->name('spaces.save');

        Route::get('spaces_view', 'ProviderController@spaces_view')->name('spaces.view');

        Route::get('spaces_delete', 'ProviderController@spaces_delete')->name('spaces.delete');

        Route::get('spaces_status_update', 'ProviderController@spaces_status')->name('spaces.status');

        /***
         *
         * Booking management
         *
         */       
        Route::get('bookings_index', 'ProviderController@bookings_index')->name('bookings.index');

        Route::get('bookings_view', 'ProviderController@bookings_view')->name('bookings.view');

        Route::get('bookings_cancel', 'ProviderController@bookings_cancel')->name('bookings.cancel');

        Route::post('bookings_review', 'ProviderController@bookings_review')->name('bookings.review');

        /****
        *
        * Pages
        * 
        */
        Route::get('/page', 'ProviderController@pages')->name('pages');

  });

});
