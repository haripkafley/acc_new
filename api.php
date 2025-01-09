<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Api\Auth\AuthController;
use  App\Http\Controllers\Api\Employee\EmployeeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// forget-password
Route::post('send-otp-password',[AuthController::class, 'sendOtp']);
Route::post('verify-otp',[AuthController::class, 'verifyOtp']);
Route::post('new-password',[AuthController::class, 'newPassword']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('add-employee',[EmployeeController::class,'add']);
    Route::get('list-employee',[EmployeeController::class,'list']);
    Route::get('delete-employee/{id}',[EmployeeController::class,'delete']);
    Route::get('edit-employee/{id}',[EmployeeController::class,'edit']);
    Route::post('update-employee',[EmployeeController::class,'update']);
    Route::get('status-employee/{id}',[EmployeeController::class,'status']);

    // profile-update
    Route::get('profile',[AuthController::class, 'profile']);
    Route::post('update-profile',[AuthController::class, 'profile_update']);
    // email-update
    Route::post('request-for-update-email',[AuthController::class, 'update_email_request']);
    Route::post('change-email',[AuthController::class, 'change_email']);

    // password-change
    Route::post('request-for-update-password',[AuthController::class, 'update_password_request']);
    Route::post('change-password',[AuthController::class, 'update_password']);

    // wages-update
    Route::get('wage-add-view/{id}',[EmployeeController::class,'wageAddView']);
    Route::post('wage-add',[EmployeeController::class,'wageAdd']);
    Route::get('wage-list/{id}',[EmployeeController::class,'wageList']);
    Route::get('wage-list/delete/{id}',[EmployeeController::class,'wageDelete']);
    Route::get('wage-list/edit/{id}',[EmployeeController::class,'wageEdit']);
    Route::post('wage-list/update',[EmployeeController::class,'wageUpdate']);

    // send-email-to-admin
    Route::post('email-send-admin',[EmployeeController::class,'emailSendAdmin']);
    
});    