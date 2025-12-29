<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\PageController;
use App\Http\Controllers\Api\V1\InAppController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Middleware\VerifyAuthToken;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('get-auth-token', [HomeController::class, 'getAuthToken']);

Route::group(['namespace' => 'Api'], function () {
    Route::group(['middleware' => ['verifyAuthToken']], function () {
        Route::post('signup', [UserController::class, 'signup']);
        Route::post('check-user', [UserController::class, 'checkUser']);
        Route::post('signin', [UserController::class, 'signin']);
        Route::post('forgot-password', [UserController::class, 'forgotPasswordOtp']);
        Route::post('reset-password', [UserController::class, 'resetPassword']);
        Route::post('verify-otp', [UserController::class, 'OtpVerify']);
        Route::post('send-otp', [UserController::class, 'sendOtp']);
        Route::get("version-control", [HomeController::class, 'versionControl']);
    });
});





Route::group(['namespace' => 'Api'], function () {

    Route::group(['middleware' => ['verifyAuthToken', 'tokenExpiryMiddleware', 'userActiveMiddleware']], function () {

        Route::post('create-edit-profile', [UserController::class, 'createEditProfile']);
        Route::post('change-password', [UserController::class, 'changePassword']);
        Route::get('get-profile', [UserController::class, 'getProfile']);
        Route::post('logout', [UserController::class, 'userLogout']);
        Route::post('delete-account', [UserController::class, 'deleteAccount']);
        Route::get('user-list', [HomeController::class, 'userlist']);
        Route::post('update-device-token', [UserController::class, 'UpdateDeviceToken']);
        
        //Subscription
        Route::post('purchase-plan', [InAppController::class, 'purchasePlan']);
        Route::post('purchase-product', [InAppController::class, 'purchaseProduct']);
        Route::post('purchase-restore', [InAppController::class, 'purchaseRestore']);
        Route::post('get-plan-list', [InAppController::class, 'getPlanList']);


        //Notification Management
        Route::post('notification-list', [NotificationController::class, 'notificationList']);
        Route::post('clear-notification', [NotificationController::class, 'clearNotification']);
        Route::post('update-notification-status', [NotificationController::class, 'updateNotificationStatus']);
 });
});
