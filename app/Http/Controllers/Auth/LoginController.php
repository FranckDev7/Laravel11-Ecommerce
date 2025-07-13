<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Le middleware guest s’applique à toutes les méthodes fournies
        // trait AuthenticatesUsers sauf logout
        $this->middleware('guest')->except('logout');

        // le middleware auth s’applique uniquement à la méthode logout.
        // signifie que l’utilisateur doit être connecté pour pouvoir se déconnecter.
        $this->middleware('auth')->only('logout');
    }
}
