<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {


        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'database' => ['required', 'string']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'address' => $data['address'],
        'password' => Hash::make($data['password'])
      ]);
    }
    public function register(Request $request)
    {
        Cache::put('db-connection', request('database','db1'), now()->addYears(100));
        $this->validator($request->all())->validate();
        $user = new User();
        $user->changeConnection($request->database);
        $email_found = $user->where('email',$request->email)->first();
        $name_found = $user->where('name', $request->name)->first();
        // return $data;
        if ($email_found || $name_found) {
            $errors=[];
            if ($email_found) {
                $errors['email'] = "Email already exists";

            }
            if ($name_found) {
                $errors['name'] = "Name already exists";

            }
            return redirect()->back()->withInput($request->input())->withErrors($errors);
        } else {
            $user=$user->create([
                'name' =>$request->name,
                'email' =>$request->email,
                'password' => Hash::make($request->password),
            ]);
            auth()->login($user, true);
            $user->changeConnection($request->database);
            $user->setDatabase($request->database);
            $user->sendEmailVerificationNotification();
        }

        return redirect('home');
    }
}
