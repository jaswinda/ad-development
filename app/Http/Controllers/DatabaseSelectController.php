<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DatabaseSelectController extends Controller
{

    public function verifyEmailAfterDatabaseSelect(EmailVerificationRequest $request) {
        Cache::put('db-connection', request('database', 'db1'), now()->addYears(100));
        $user = new User();
        $user->changeConnection($request->database);
        $user = $user->where('id', $request->id)->first();
        if ($user && $user->email == $request->email) {
            $request->fulfill($user);
            return ['message' => 'Email verified successfully', 'success' => true];
        }
        return ['message' => 'User Not Found With That email',  'success' => false];
    }

    public function goSelectingDatabaseForEmailVerify(EmailVerificationRequest $request) {
        if ($request->db) {
            $user = User::where('id', $request->id)->first();
            if ($user && $user->email == $request->email) {
                $request->changeConnection($request->db);
                $request->fulfill($user);
                return redirect('/home');
            }
        }
        return view('auth.database-selector')->with('data', $request);
    }

    public function sendEmailVerificationNotification(Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }
}
