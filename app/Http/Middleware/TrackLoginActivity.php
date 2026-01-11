<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackLoginActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Auth::check() && $this->shouldTrack($request)) {
            $user = Auth::user();
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);
        }

        return $response;
    }

    private function shouldTrack(Request $request): bool
    {
        // Only track successful logins (not every request)
        // You can adjust this logic based on your needs
        return $request->isMethod('POST') && $request->routeIs('admin.login.post');
    }
}
