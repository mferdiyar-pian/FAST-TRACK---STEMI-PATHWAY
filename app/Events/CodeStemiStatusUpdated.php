<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\CodeStemi;

class CodeStemiStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $runningCount;
    public $finishedCount;
    public $recentActivities;
    public $lastUpdate;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        $this->updateStats();
    }

    /**
     * Update statistics data
     */
    private function updateStats()
    {
        // Hitung jumlah Running dan Finished
        $this->runningCount = CodeStemi::where('status', 'Running')->count();
        $this->finishedCount = CodeStemi::where('status', 'Finished')->count();
        
        // Ambil aktivitas terbaru
        $this->recentActivities = CodeStemi::orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'formatted_date' => $item->formatted_date,
                    'door_to_balloon_time' => $item->door_to_balloon_time,
                    'user_name' => 'System'
                ];
            });

        // Waktu update terakhir
        $this->lastUpdate = now()->setTimezone('Asia/Makassar')->format('H:i:s');
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('code-stemi-dashboard');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'status.updated';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'runningCount' => $this->runningCount,
            'finishedCount' => $this->finishedCount,
            'recentActivities' => $this->recentActivities,
            'lastUpdate' => $this->lastUpdate,
            'timestamp' => now()->setTimezone('Asia/Makassar')->toISOString()
        ];
    }
}