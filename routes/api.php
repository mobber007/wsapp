<?php

use Illuminate\Http\Request;
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::post('favorite/{product}', 'Favorites\FavoriteController@favorite');
    Route::post('unfavorite/{product}', 'Favorites\FavoriteController@unfavorite');
    Route::get('favorite','Favorites\FavoriteController@index');
});
Route::group(['middleware' => ['auth:api','role:guru']], function () {
Route::get('users','Dashboard\DashboardController@users');
Route::get('dashboard','Dashboard\DashboardController@index');
Route::get('products','Dashboard\DashboardController@products');
});

Route::post('contact','Communication\ContactUsController@contact');
Route::resource('product','Products\ProductController');
Route::resource('promotion','Promotions\PromotionController');
Route::resource('feature','Feature\FeatureController');
Route::resource('popular','Popular\PopularController');
Route::resource('category','Categories\CategoryController');
Route::resource('brand','Brands\BrandController');
Route::resource('affiliate','Affiliates\AffiliateController');
Route::resource('image','Images\ImageController');
Route::get('similars/{product}', 'Products\ProductController@get_similars')->name('similars');

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::post('auth', 'Auth\SocialController@social');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
