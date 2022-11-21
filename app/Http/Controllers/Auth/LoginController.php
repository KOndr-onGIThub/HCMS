<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*Loaded from external libraries (Tpca network disk)*/
use UserLaravel;

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
    protected $redirectTo = '/';

    
    public function login(Request $request)
    {        
        return view("login");
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        /*If not found LDAP username, contionue as classic login form*/
        if (Auth::validate(['username' => strtolower($request->login), 'password' => $request->password])) {
            return redirect('/');
        } else {
            return redirect()->back()->withErrors('error', 'Vaše přihlašovací údaje nejsou správné.')->withInput();
        }
    }

    /* Odhlášení */
    public function logout(Request $request)
    {        
        $request->session()->invalidate();
        
        Auth::logout();
        
        return redirect('/login');
    }
}
