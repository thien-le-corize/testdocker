<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Admin\Auth',
], function () {
    Route::post('/login', 'AdminLoginController');
});

Route::group([
    'middleware' => ['auth:api', 'isAdmin'],
], function () {
    Route::group([
        'namespace' => 'Admin\Auth',
    ], function () {
        Route::post('/refresh-token', 'RefreshTokenController');
        Route::get('/logout', 'AdminLogoutController');
    });

    Route::group([
        'namespace' => 'Admin\Category',
        'prefix' => 'category',
    ], function () {
        Route::post('/', 'AdminCreateCategoryController');
        Route::get('/', 'AdminListCategoryController');
        Route::put('/', 'AdminUpdateCategoryController');
        Route::delete('/', 'AdminDeleteCategoryController');

        Route::post('/attribute-type', 'AdminCreateAttributeTypeController');
        Route::post('/attribute-value', 'AdminCreateAttributeValueController');
        Route::post('/attribute', 'AdminCreateAttributeController');

        Route::get('/attribute', 'AdminListAttributeController');
        Route::get('/attribute-type', 'AdminListAttributeTypeController');
    });
});