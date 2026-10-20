<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;

class AuthenticateToken
{
    public function __construct(private UserRepository $users) {}

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $user = $token ? $this->users->getUserByToken(hash('sha256', $token)) : null;

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Session expired. Sign in again.'], 401);
        }

        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
