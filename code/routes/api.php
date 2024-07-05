<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;


Route::get('customers', [ApiController::class,"fetchCustomers"]);
Route::get('customer/{id}', [ApiController::class,"showCustomer"]);
Route::post('customer/add', [ApiController::class,"addCustomer"]);
Route::delete('customer/delete/{id}', [ApiController::class,"deleteCustomer"]);
Route::put('customer/update/{id}', [ApiController::class,"updateCustomer"]);