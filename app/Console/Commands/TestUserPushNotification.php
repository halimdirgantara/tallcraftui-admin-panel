<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\CustomUserNotification;

class TestUserPushNotification extends Command
{
    protected $signature = 'test:user-push-notification {user_id}';
    protected $description = 'Send a test push notification to a user';

    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);
        if (!$user) {
            $this->error('User not found.');
            return 1;
        }
        $user->notify(new CustomUserNotification('This is a test push notification! on '.date('Y-m-d H:i:s').' .'));
        $this->info('Test push notification sent to user ID ' . $userId);
        return 0;
    }
} 