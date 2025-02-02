<?php

namespace App\Http\Middleware;

use App\Models\VisitorCount;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $ipAddress = $request->ip();
        $today = Carbon::today();

        $existingVisit = VisitorCount::where('ip_address', $ipAddress)
                                     ->whereDate('visit_date', $today)
                                     ->exists();

        if (!$existingVisit) {
            VisitorCount::create([
                'ip_address' => $ipAddress,
                'visit_date' => $today
            ]);
        }

        return $next($request);
    }
}
