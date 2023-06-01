<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('device')->group(function(){
        Route::get('/', [DeviceController::class, 'index'])->name('device.index');
        Route::get('/add', [DeviceController::class, 'add'])->name('device.add');
        Route::post('/store', [DeviceController::class, 'store'])->name('device.store');
        Route::get('/scan/{device}', [DeviceController::class, 'scan'])->name('device.scan');
    });

});
