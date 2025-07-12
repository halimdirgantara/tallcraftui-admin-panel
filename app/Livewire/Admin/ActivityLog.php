<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Component
{
    use WithPagination;

    public $search = '';
    public $filterLogName = '';
    public $filterEvent = '';
    public $filterDate = '';
    public $selectedActivity = null;
    public $showDetails = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterLogName' => ['except' => ''],
        'filterEvent' => ['except' => ''],
        'filterDate' => ['except' => ''],
    ];

    public function mount()
    {
        // Check if user has permission to view activity logs
        if (!Auth::user()->can('view activity logs')) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterLogName()
    {
        $this->resetPage();
    }

    public function updatedFilterEvent()
    {
        $this->resetPage();
    }

    public function updatedFilterDate()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'filterLogName', 'filterEvent', 'filterDate']);
        $this->resetPage();
    }

    public function showActivityDetails($activityId)
    {
        $this->selectedActivity = Activity::find($activityId);
        $this->showDetails = true;
    }

    public function closeDetails()
    {
        $this->selectedActivity = null;
        $this->showDetails = false;
    }

    public function deleteActivity($activityId)
    {
        if (!Auth::user()->can('delete activity logs')) {
            session()->flash('error', 'You do not have permission to delete activity logs.');
            return;
        }

        $activity = Activity::find($activityId);
        if ($activity) {
            $activity->delete();
            session()->flash('success', 'Activity log deleted successfully.');
        }
    }

    public function clearAllLogs()
    {
        if (!Auth::user()->can('delete activity logs')) {
            session()->flash('error', 'You do not have permission to delete activity logs.');
            return;
        }

        Activity::truncate();
        session()->flash('success', 'All activity logs cleared successfully.');
    }

    public function render()
    {
        $query = Activity::query()
            ->with(['causer', 'subject'])
            ->orderBy('created_at', 'desc');

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhere('log_name', 'like', '%' . $this->search . '%')
                  ->orWhere('event', 'like', '%' . $this->search . '%')
                  ->orWhereHas('causer', function ($causerQuery) {
                      $causerQuery->where('name', 'like', '%' . $this->search . '%')
                                 ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply log name filter
        if (!empty($this->filterLogName)) {
            $query->where('log_name', $this->filterLogName);
        }

        // Apply event filter
        if (!empty($this->filterEvent)) {
            $query->where('event', $this->filterEvent);
        }

        // Apply date filter
        if (!empty($this->filterDate)) {
            $query->whereDate('created_at', $this->filterDate);
        }

        $activities = $query->paginate(20);

        // Get unique log names and events for filters
        $logNames = Activity::distinct()->pluck('log_name')->filter()->values();
        $events = Activity::distinct()->pluck('event')->filter()->values();

        return view('livewire.admin.activity-log', [
            'activities' => $activities,
            'logNames' => $logNames,
            'events' => $events,
        ]);
    }
} 