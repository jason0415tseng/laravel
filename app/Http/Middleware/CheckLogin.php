<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $Value = $request->session()->get('account');
        $Path = explode('/', $request->path());
        if (count($Path) >= 2) {
            if (!$Value) {
                return redirect('/login');
            }
        } else {
            if ($Value) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
