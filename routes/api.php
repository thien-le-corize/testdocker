<?php

use Illuminate\Support\Facades\Route;


// COMMON 
Route::group([
    'middleware' => ['auth:api'],
], function () {
    Route::group([
        'namespace' => 'App\Http\Controllers\Auth',
    ], function () {
        Route::post('/refresh-token', 'RefreshTokenController');
        Route::get('/logout', 'LogoutController');
        Route::get('/me', 'GetMeController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\Category',
        'prefix' => 'category',
    ], function () {
        Route::post('/', 'CreateCategoryController');
        Route::get('/', 'ListCategoryController');
        Route::put('/', 'UpdateCategoryController');
        Route::delete('/', 'DeleteCategoryController');

        Route::post('/attribute-type', 'CreateAttributeTypeController');
        Route::post('/attribute-value', 'CreateAttributeValueController');
        Route::post('/attribute', 'CreateAttributeController');

        Route::get('/attribute', 'ListAttributeController');
        Route::get('/attribute-type', 'ListAttributeTypeController');

        Route::get('/get-category-of-user', 'ListCategoryOfUserController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\Product',
        'prefix' => 'product',
    ], function () {
        Route::post('/', 'CreateProductController');
        Route::put('/', 'UpdateProductController');
        Route::delete('/{id}', 'DeleteProductController');
        Route::put('/wishlist', 'CreateWishListProductController');
        Route::put('/approval', 'ApprovalProductController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\Cart',
        'prefix' => 'cart',
    ], function () {
        Route::post('/', 'CreateCartController');
        Route::put('/', 'UpdateCartController');
        Route::get('/', 'GetCartController');
        // Route::get('/count', 'GetCartCountController');
        Route::delete('/', 'DeleteCartController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\Address',
        'prefix' => 'user/address',
    ], function () {
        Route::post('/','CreateAddressController');
        Route::get('/{id}','DetailAddressController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\Order',
        'prefix' => 'order',
    ], function () {
        Route::post('/','CreateOrderController');
        Route::get('/','ListOrderController');
        Route::get('/{id}','DetailOrderController');
        Route::get('/print/{orderCode}','PrintOrderController');
        Route::post('/shopping-fee','GetShoppingFeeController');
        Route::get('/get-url-payment','GetUrlPaymentController');
        Route::post('/verify','ReturnUrlController');
        Route::put('/status','UpdateStatusOrderController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\Voucher',
        'prefix' => 'voucher',
    ], function () {
        Route::post('/', 'CreateVoucherController');
        Route::put('/', 'UpdateVoucherController');
        Route::get('/', 'ListVoucherController');
        Route::delete('/{id}', 'DeleteVoucherController');
        Route::get('/voucher-by-shop/{shopId}', 'GetVoucherByShopController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\ShopeeVoucher',
        'prefix' => 'shopee-voucher',
    ], function () {
        Route::post('/', 'CreateShopeeVoucherController');
        Route::get('/', 'ListShopeeVoucherController');
        Route::put('/', 'UpdateShopeeVoucherController');
        Route::delete('/{id}', 'DeleteShopeeVoucherController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\User',
        'prefix' => 'user',
    ], function () {
        Route::get('/', 'ListUserController');
        Route::delete('/{id}', 'DeleteUserController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\Review',
        'prefix' => 'review',
    ], function () {
        Route::post('/{orderID}', 'CreateReviewController');
        Route::get('/product/{productID}', 'GetReviewController');
    });
});


// NO AUTHEN
Route::group([

], function () {
    Route::group([
        'namespace' => 'App\Http\Controllers\Product',
        'prefix' => 'product',
    ], function () {
        Route::get('/{id}', 'DetailProductController');
        Route::get('/', 'ListProductController');
    });


    Route::group([
        'namespace' => 'App\Http\Controllers\Category',
        'prefix' => 'category',
    ], function () {
        Route::get('/', 'ListCategoryController');
        Route::get('/{id}', 'DetailCategoryController');
        Route::get('/get-category-of-user', 'ListCategoryOfUserController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\Shop',
        'prefix' => 'shop',
    ], function () {
        Route::get('/{id}', 'GetShopController');
        Route::get('/', 'ListShopController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\Auth',
    ], function () {
        Route::post('/register', 'RegisterController');
        Route::post('/login', 'LoginController');
        Route::get('/verify-email','VerifyEmailController');
        Route::post('/forgot-password','ForgotPasswordController');
        Route::put('/reset-password','ResetPasswordController');
    });
    
    Route::group([
        'namespace' => 'App\Http\Controllers\Address',
    ], function () {
        Route::get('/province','GetProvinceController');
        Route::get('/district','GetDistrictController');
        Route::get('/ward','GetWardController');
    });

    Route::group([
        'namespace' => 'App\Http\Controllers\Order',
        'prefix' => 'order',
    ], function () {
        Route::get('/print/{orderCode}','PrintOrderController');
    });

});


