<?php

namespace App\Http\Middleware;

use Closure;

class CheckSession
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
        
        $Message = session()->get('Message');

        $Account = session()->get('account');
        if(!$Account){
            return redirect('login');
        }

        if(!$Message){
            return redirect('/');
        }

        return $next($request);
    }
}
