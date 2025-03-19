<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()){
            return redirect('/dang-nhap');
        }

        $user = Auth::user();
        if ($user->role != 'admin') {
            abort(404);
        }
        return $next($request);
    }
}
