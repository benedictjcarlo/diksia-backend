<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\DonationController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\ShipmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('updateProfile', [UserController::class, 'updateProfile']);
    Route::post('user/photo', [UserController::class, 'updatePhoto']);
    Route::get('transaction', [TransactionController::class, 'all']);
    Route::post('transaction/{id}', [TransactionController::class, 'update']);
    Route::post('checkout', [TransactionController::class, 'checkout']);
    Route::get('shipment', [ShipmentController::class, 'all']);
    Route::post('shipment/{id}', [ShipmentController::class, 'update']);
    Route::post('shipmentGadget', [ShipmentController::class, 'shipmentGadget']);
    Route::post('shipment/photo', [ShipmentController::class, 'updateShipmentPhoto']);
    Route::post('logout', [UserController::class, 'logout']);
});

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::get('verify-email/{token}', [UserController::class, 'verifyEmail']);

Route::get('donation', [DonationController::class, 'all']);