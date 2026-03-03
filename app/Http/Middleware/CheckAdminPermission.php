<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || !$admin->hasPermission($permission)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized access.'], 403);
            }
            
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this section.');
        }

        return $next($request);
    }
}
