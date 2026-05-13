<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiCustomerController;

Route::get('/layanan', [ApiController::class, 'getData']);

Route::get('/customers', [ApiCustomerController::class, 'index']);

Route::get('/customers/{id}', [ApiCustomerController::class, 'show']);

Route::post('/customers', [ApiCustomerController::class, 'store']);
Route::put('/customers/{id}', [ApiCustomerController::class, 'update']);
Route::delete('/customers/{id}', [ApiCustomerController::class, 'destroy']);