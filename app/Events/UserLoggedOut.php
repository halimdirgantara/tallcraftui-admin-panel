<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class UserLoggedOut
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $request;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Request $request = null)
    {
        $this->user = $user;
        $this->request = $request;
    }
} 