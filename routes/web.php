<?php

use App\Http\Controllers\CustomerController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

// Route::get('/customer', function () {
//     return view('customer');
// });




Route::get('/customer', [CustomerController::class, 'index']);
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
