<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Seller\Auth',
], function () {
    Route::post('/register', 'SellerRegisterController');
    Route::post('/login', 'SellerLoginController');
    Route::get('/verify-email','SellerVerifyEmailController');
    Route::post('/forgot-password','SellerForgotPasswordController');
    Route::put('/reset-password','SellerResetPasswordController');
});

Route::group([
    'middleware' => ['auth:api', 'isSeller'],
], function () {
    
    Route::group([
        'namespace' => 'Seller\Auth',
    ], function () {
        Route::get('/logout', 'SellerLogoutController');
        Route::put('/change-password','SellerChangePasswordController');
    });

    Route::group([
        'namespace' => 'Seller\Category',
        'prefix' => 'category', 
    ], function () {
        Route::get('/', 'SellerListCategoryController');
        Route::get('/attribute', 'SellerListAttributeController');
    });
});

