<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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


Route::post('/signin', [LoginController::class, 'signIn'])->name('auth.singin');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::view('/register', 'auth.register');

Auth::routes([
    'register' => false,
    'verify' => true
]);

Route::get('/', function () {
    return redirect('/home');
});

Route::group(['middleware' => 'auth'], function () {
    Route::view('/', 'welcome');
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->middleware('auth')->name('verification.notice');


    Route::post('/verify-my-email/{database}/email/verify/{id}/{hash}',  function (EmailVerificationRequest $request) {
        Cache::put('db-connection', request('database', 'db1'), now()->addYears(100));
        $user = new User();
        $user->changeConnection($request->database);
        $user = $user->where('id', $request->id)->first();
        if ($user && $user->email == $request->email) {
            $request->fulfill($user);
            return ['message' => 'Email verified successfully', 'success' => true];
        }
        return ['message' => 'User Not Found With That email',  'success' => false];
    });

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        if ($request->db) {
            $user = User::where('id', $request->id)->first();
            if ($user && $user->email == $request->email) {
                $request->changeConnection($request->db);
                $request->fulfill($user);
                return redirect('/home');
            }
        }
        return view('auth.database-selector')->with('data', $request);
    })->name('verification.verify');

    Route::post('/compress-image', [\App\Http\Controllers\ImageCompressController::class, 'compressImage']);
});



Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


