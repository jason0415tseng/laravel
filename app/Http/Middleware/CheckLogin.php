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
        // echo "ASDAd";
        // exit;
        $Value = $request->session()->get('account');
        // dd($request->path());
        // $Path = $request->path();
        $Path = explode('/', $request->path());
        // dd($Path);
        if (count($Path) > 2) {

            if (!$Value) {
                //  dd($Value);
                return redirect('/login');
            }
        } else {

            if ($Value) {
                // dd($Value);
                return redirect('/');
            }
        }

        return $next($request);
    }
}
