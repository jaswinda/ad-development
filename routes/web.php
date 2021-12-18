<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DatabaseSelectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageCompressController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
Auth::routes([
    'register' => false,
    'verify' => true
]);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', function () {return redirect('/home');});
Route::post('/signin', [LoginController::class, 'signIn'])->name('auth.singin');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::view('/register', 'auth.register');

Route::group(['middleware' => 'auth'], function () {
    Route::view('/', 'welcome');
    Route::view('/email/verify', 'auth.verify')->name('verification.notice');
    Route::post('/verify-my-email/{database}/email/verify/{id}/{hash}',  [DatabaseSelectController::class, 'verifyEmailAfterDatabaseSelect']);
    Route::get('/email/verify/{id}/{hash}',[DatabaseSelectController::class,'goSelectingDatabaseForEmailVerify'])->name('verification.verify');
    Route::post('/compress-image', [ImageCompressController::class, 'compressImage']);
    Route::post('/email/verification-notification',[DatabaseSelectController::class, 'sendEmailVerificationNotification'])->middleware(['throttle:6,1'])->name('verification.send');
});




