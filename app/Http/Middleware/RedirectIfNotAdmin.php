<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\User;
use App\Admin;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    protected $redirectTo = 'admin';
    protected $guard = 'web';
 
    
    public function handle($request, Closure $next, $guard = 'web')
    {
        if (!Auth::guard($guard)->check() && !Auth::guard('admin')->check()) {
            return redirect('admin/login');
        }
       return $next($request)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
