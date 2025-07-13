<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * Closure $next : une fonction anonyme (appelée closure) qui permet de continuer l'exécution
     * de la requête vers le prochain middleware ou le contrôleur.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) // vérifie si l'utilisateur est connecté (authentifié).
        {
            /**
             * Auth::user() : récupère l'utilisateur connecté.
             * ->utype : accède à la propriété utype
             * === 'ADM' : on vérifie si le type d'utilisateur est bien ADM (admin).
             */
            if(Auth::user()->utype === 'ADM')
            {
                return $next($request); // $next (closure) : continue l'execution de la requête vars d'autres middlewares ou contrôleur
            }else{
                Session::flush(); // Supprime toutes les données de session
                return redirect()->route('login');
            }
        }else{
            return redirect()->route('login');
        }
    }
}
