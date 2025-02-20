<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastAuthMiddleware
{
    /**
     * Manejar la solicitud entrante.
     */
    public function handle(Request $request, Closure $next)
    {
        dd(Carbon::now(),Auth::check(),auth()->id());
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => 'Authentication required for broadcasting.'
            ], 401);
        }

        return $next($request);
    }
}
