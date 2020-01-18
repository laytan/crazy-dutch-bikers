<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

/**
 * Checks the user id in the route or the email in the request against the logged in user.
 */
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
        // Go next if the user is an admin
        if(Auth::user()->hasAnyRole(['admin', 'super-admin'])) {
            return $next($request);
        }

        $errorMsg = 'U heeft niet de juiste rechten voor deze actie.';

        // Error when the request has the user id and it is not the same as the logged in user id.
        $userId = (int) $request->route('id');
        if($userId !== null && $userId !== Auth::user()->id) {
            return back()->with('error', $errorMsg);
        } elseif($request->email && $request->email !== Auth::user()->email) {
            return back()->with('error', $errorMsg);
        }

        return $next($request);
    }
}
