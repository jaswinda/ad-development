<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    // protected $connection = 'db1';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( Request $request)
    {
        // dd($request->all());
        $this->middleware('guest')->except('logout');
    }

    public function signIn(Request $request)
    {
        Cache::put('db-connection', request('database','db1'), now()->addYears(100));
        $this->validateLogin($request);
        $user = new User();
        $user->changeConnection($request->database);

        $user = $user->where('email', $request->email)->first();
        if(!$user){
            return redirect()->back()->withInput($request->input())->withErrors(['email'=>'Email not found']);
        }else{
             // Check password
            if(!Hash::check($request->password, $user->password)) {
                return redirect()->back()->withInput($request->input())->withErrors(['password'=>'Password is incorrect']);
            }else{
                $token = Str::random(60);
                $user->changeConnection($request->database);
                $user->setRememberToken($token);
                session(['user'=>$user]);
                auth()
                ->setConnection($request->database)
                ->login($user, true);
                return redirect('home');
            }
        }



    }

    // public function onLogin(Request $request)
    // {
    //     // return $request;

    //     $this->validate($request, [
    //         'email'   => 'required|email',
    //         'password' => 'required|min:6'
    //     ]);
    //     $user = new User();
    //     $user->setConnection($request->database);
    //     $user->email = $request->email;
    //     $user->password = $request->password;


    //     // if (auth()->guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
    //     if (auth()->guard('web')->login($user)) {

    //         return redirect()->intended('/');
    //     }
    //     return back()->withInput($request->only('email', 'remember'))->with('status', 'Incorrect login credentials');
    // }
    // public function logout(Request $request)
    // {
    //     Auth::guard('web')->logout();
    //     $request->session()->flush();
    //     return redirect(route('app.login'));
    // }
}
