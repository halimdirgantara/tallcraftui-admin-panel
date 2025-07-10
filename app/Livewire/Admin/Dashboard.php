<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        $totalUsers = User::count();
        $activeSessions = DB::table('sessions')->count();
        $systemLoad = rand(20, 80); // Mock system load
        
        $recentActivity = [
            [
                'message' => 'New user registered: john@example.com',
                'time' => '2 minutes ago'
            ],
            [
                'message' => 'System backup completed successfully',
                'time' => '15 minutes ago'
            ],
            [
                'message' => 'Database optimization completed',
                'time' => '1 hour ago'
            ],
            [
                'message' => 'Security update installed',
                'time' => '2 hours ago'
            ]
        ];

        return view('livewire.admin.dashboard', [
            'totalUsers' => $totalUsers,
            'activeSessions' => $activeSessions,
            'systemLoad' => $systemLoad,
            'recentActivity' => $recentActivity
        ]);
    }
} 