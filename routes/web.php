<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('rahasia-negara', function() {
});
Auth::routes(['register' => false, 'login' => false]);
Route::get('rahasia-negara', [LoginController::class, 'showLoginForm']);
Route::post('rahasia-negara', [LoginController::class, 'login'])->name('login');

Route::middleware('auth')->group(function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::prefix('device')->group(function(){
        Route::get('/', [DeviceController::class, 'index'])->name('device.index');
        Route::get('/add', [DeviceController::class, 'add'])->name('device.add');
        Route::post('/store', [DeviceController::class, 'store'])->name('device.store');
        Route::get('/scan/{device}', [DeviceController::class, 'scan'])->name('device.scan');
    });
    Route::prefix('member')->group(function(){
        Route::get('/', [MemberController::class, 'index'])->name('member.index');
        Route::get('/add', [MemberController::class, 'add'])->name('member.add');
        Route::get('/edit/{member}', [MemberController::class, 'edit'])->name('member.edit');
        Route::post('/store', [MemberController::class, 'store'])->name('member.store');
    });
});
