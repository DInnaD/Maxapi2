<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        if($request->user() === null){
            return response()->json(['success' => false, 'message' => 'Insufficient permissions']);
        }

        if($request->user()->admin){
            return $next($request);
        }
        return response()->json(['success' => false, 'message' => 'Insufficient permissions']);

    }
}
