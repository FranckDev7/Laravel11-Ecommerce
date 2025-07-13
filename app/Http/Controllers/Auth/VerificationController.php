<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        // Applique le middleware auth à toutes les méthodes fournies par le trait VerifiesEmails.
        $this->middleware('auth');

        // Applique le middleware signed uniquement à la méthode verify.
        $this->middleware('signed')->only('verify');

        // Applique le middleware throttle (limitation de requêtes) aux méthodes verify et resend.
        // L’utilisateur peut faire 6 tentatives max par minute (6,1),
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
