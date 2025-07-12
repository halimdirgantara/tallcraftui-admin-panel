<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log login activity
        if (Auth::check() && !session('activity_logged')) {
            $this->logUserActivity('login', $request);
            session(['activity_logged' => true]);
        }

        return $response;
    }

    /**
     * Log user activity with detailed information
     */
    protected function logUserActivity($event, Request $request)
    {
        if (!Auth::check()) {
            return;
        }

        $agent = new Agent();
        
        $activityData = [
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'is_mobile' => $agent->isMobile(),
            'is_tablet' => $agent->isTablet(),
            'is_desktop' => $agent->isDesktop(),
            'is_robot' => $agent->isRobot(),
            'referer' => $request->header('referer'),
            'session_id' => session()->getId(),
        ];

        activity()
            ->causedBy(Auth::user())
            ->withProperties($activityData)
            ->log("User {$event}");
    }
} 