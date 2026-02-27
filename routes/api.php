<?php

use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

// Import the class
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', 'App\Http\Controllers\Api\AuthController@login');
Route::group(['as' => 'api.', 'namespace' => 'Api', 'middleware' => ['auth:sanctum']], function () {
    Route::post('contracts/{contract}/invoices', [InvoiceController::class, 'store']);
    Route::get('contracts/{contract}/invoices', [InvoiceController::class, 'list']);
    Route::get('invoices/{invoice}', [InvoiceController::class, 'get_by_id']);
    Route::post('invoices/{invoice}/payment', [PaymentController::class, 'record_payment']);
    Route::get('contracts/{contract}/summary', [ContractController::class, 'summary']);
});
