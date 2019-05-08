<?php

namespace App\Http\Middleware;

use Closure;

class CheckManager
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
        $Account = session()->get('account');
        $Level = session()->get('level');
        if ((!$Account) && (!$Level)) {
            return redirect('/');
        } else {
            if ($Level > 2) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
