<?php

namespace App\Listeners;

use App\Events\UserLoggedOut;
use Jenssegers\Agent\Agent;

class LogUserLogout
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedOut $event): void
    {
        $agent = new Agent();
        $request = $event->request;
        
        $activityData = [
            'ip_address' => $request ? $request->ip() : null,
            'user_agent' => $request ? $request->userAgent() : null,
            'browser' => $request ? $agent->browser() : null,
            'browser_version' => $request ? $agent->version($agent->browser()) : null,
            'platform' => $request ? $agent->platform() : null,
            'device' => $request ? $agent->device() : null,
            'is_mobile' => $request ? $agent->isMobile() : null,
            'is_tablet' => $request ? $agent->isTablet() : null,
            'is_desktop' => $request ? $agent->isDesktop() : null,
            'is_robot' => $request ? $agent->isRobot() : null,
            'referer' => $request ? $request->header('referer') : null,
            'session_id' => session()->getId(),
        ];

        activity()
            ->causedBy($event->user)
            ->withProperties($activityData)
            ->log('User logout');
    }
} 