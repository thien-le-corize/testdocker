<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'User\Auth',
], function () {
    Route::post('/register', 'UserRegisterController');
    Route::post('/login', 'UserLoginController');
    Route::get('/verify-email','UserVerifyEmailController');
    Route::post('/forgot-password','UserForgotPasswordController');
    Route::put('/reset-password','UserResetPasswordController');
});

Route::group([
    'middleware' => ['auth:api', 'isUser'],
], function () {
    
    Route::group([
        'namespace' => 'User\Auth',
    ], function () {
        Route::get('/logout', 'UserLogoutController');
        Route::put('/change-password','UserChangePasswordController');
    });

    Route::group([
        'namespace' => 'User\Category',
        'prefix' => 'category', 
    ], function () {
        Route::get('/', 'UserListCategoryController');
    });
});

