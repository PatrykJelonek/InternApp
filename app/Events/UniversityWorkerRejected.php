<?php

namespace App\Events;

use App\Models\University;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UniversityWorkerRejected implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var University
     */
    public $university;

    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    public $reason;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(University $university, User $user, string $reason)
    {
        $this->university = $university;
        $this->user = $user;
        $this->reason = $reason;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
