<?php

namespace App\Http\Middleware;

use Closure;

class SameUserOrAdmin
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
        if($request->email !== \Auth::user()->email && \Auth::user()->hasRole('member')) {
            return back()->with('error', 'Gebruiker heeft niet de rechten voor deze actie.');
        }

        if(!\Auth::user()->hasAnyRole(['admin', 'super-admin'])) {
            return back()->with('error', 'Gebruiker heeft niet de rechten voor deze actie.');
        }

        return $next($request);
    }
}
