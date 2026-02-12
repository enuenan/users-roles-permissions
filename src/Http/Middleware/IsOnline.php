<?php

/*
 * Copyright enuenan. All rights reserved.
 * @auth enuenan
 * @link  https://github.com/enuenan
 */

namespace enuenan\UsersRolesPermissions\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class IsOnline
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $expireAt = now()->addMinutes(2);
            Cache::put('user-is-online.'.Auth()->id(), true, $expireAt);
            $user = Auth::user();
            $user->stopUserstamping();
            $user->last_seen = now();
            $user->save();
            $user->startUserstamping();
        }

        return $next($request);
    }
}
