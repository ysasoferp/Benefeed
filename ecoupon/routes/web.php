<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('login');
});

route::post('Adminlogin', 'HomeController@Adminlogin')->name('Adminlogin');
Route::get('/privacy-policy', 'HomeController@privacy')->name('privacy');
Auth::routes();


Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/coupon-scanned-chart-data', 'HomeController@getDataForGraphTotalCouponScanned');

    Route::get('coupon/import', 'CouponController@importCoupon')->name('importCoupon');
    Route::post('coupon/import', 'CouponController@importCouponStore')->name('importCouponStore');
    Route::get('coupon/couponlist', 'CouponController@showCoupon')->name('showCoupon');
    Route::post('coupon/delete/{id}', 'CouponController@deleteCoupon')->name('deleteCoupon');
    Route::get('/withdrawl', 'WithdrawController@index')->name('withdrawl');
    Route::get('/marketing', 'MarketingController@index')->name('marketing');
    Route::post('/uploadBanner', 'MarketingController@store')->name('uploadBanner');
    Route::post('/market/delete/{id}', 'MarketingController@deleteMarket')->name('deleteMarket');
    Route::get('/customers', 'CustomerController@index')->name('customers');
    Route::get('/users', 'CustomerController@users')->name('users');
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::post('/settings', 'SettingsController@store')->name('Storesettings');

    Route::get('/location', 'LocationController@index')->name('location');
    Route::post('/location', 'LocationController@store')->name('locationStore');
    Route::post('/location/delete/{id}', 'LocationController@deleteLocation')->name('deleteLocation');

    Route::get('/store-name', 'StoreController@index')->name('storeName');
    Route::post('/store-name', 'StoreController@store')->name('storeNameStore');
    Route::post('/store-name/delete/{id}', 'StoreController@deleteStore')->name('deleteStoreName');

    Route::get('/pages', 'PageController@index')->name('pages');
    Route::get('/apipages', 'PageController@getData')->name('getData');
    Route::post('/pages', 'PageController@store')->name('Storepages');
    Route::post('/user/delete/{id}', 'CustomerController@deleteUser')->name('deleteUser');
    Route::get('/user/getupdate/{id}', 'CustomerController@UpdateUser')->name('UpdateUser');
    Route::post('/user/update/', 'CustomerController@postUpdateUser')->name('postUpdateUser');
    Route::post('/custom/delete/{id}', 'CustomerController@deleteCustom')->name('deleteCustom');
    Route::post('editWithdraw', 'WithdrawController@editWithdraw')->name('editWithdraw');

    Route::get('/ExportQR', 'CustomerController@ExportQR')->name('ExportQR');
    Route::get('/custom/edit/{id}', 'CustomerController@editCustom')->name('editCustom');
    Route::post('/custom/activate', 'CustomerController@activateCustom')->name('activateCustom');
    Route::post('registerUser', 'CustomerController@registerUser')->name('registerUser');
    Route::get('ExportWithdrawlData', 'WithdrawController@ExportWithdrawlData')->name('ExportWithdrawlData');
    Route::get('ExportCoupon', 'CouponController@ExportCoupon')->name('ExportCoupon');
    Route::get('appinfo', 'SettingsController@appInfo')->name('appInfo');
    Route::post('appinfostore', 'SettingsController@appinfostore')->name('appinfostore');

});

//App APi Collection

Route::get('/getAdminData', 'PageController@getAdminData')->name('getAdminData');
Route::get('/registerCustomer', 'CustomerController@register')->name('register_customer');
Route::get('/registerLogin', 'CustomerController@registerLogin')->name('registerLogin');
Route::get('/loginCustomer', 'CustomerController@loginUser')->name('loginUser');
Route::get('changePassword', 'CustomerController@changePassword')->name('changePassword');
Route::get('getUserData/{id}', 'CustomerController@getUserData')->name('getUserData');
Route::get('getLocation', 'CustomerController@getLocation')->name('getLocation');
Route::post('uploadProfileData', 'CustomerController@uploadProfileData')->name('uploadProfileData');
Route::get('couponVerify', 'CouponController@couponVerify')->name('couponVerify');
Route::get('withdrawMoney', 'WithdrawController@withdrawMoney')->name('withdrawMoney');
Route::get('transferMoney', 'WithdrawController@transferMoney')->name('transferMoney');
Route::get('transferMoneyMobile', 'WithdrawController@transferMoneyMobile')->name('transferMoneyMobile');
Route::get('dealerVerify', 'WithdrawController@dealerVerify')->name('dealerVerify');
Route::get('transferHistory/{id}', 'WithdrawController@transferHistory')->name('transferHistory');
Route::get('/getLocation', 'LocationController@getLocation')->name('getLocation');
Route::get('/getProfileData/{id}', 'CustomerController@getProfileData')->name('getProfileData');
Route::get('/forgotPassEmail/{email}', 'CustomerController@forgotPassEmail')->name('forgotPassEmail');
Route::get('/resetPass/{expire}', 'CustomerController@resetPass')->name('resetPass');
Route::post('resetPassApp', 'CustomerController@resetPassApp')->name('resetPassApp');
Route::get('getNotification', 'SettingsController@getNotification')->name('getNotification');
Route::get('setNotification', 'SettingsController@setNotification')->name('setNotification');
Route::get('getAppinfo', 'SettingsController@getAppinfo')->name('getAppinfo');

Route::get('marketImage', 'MarketingController@marketImage')->name('marketImage');

Route::get('/getProfileData', function () {


    return view('test');
});
