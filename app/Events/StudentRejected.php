<?php

namespace App\Events;

use App\Models\Student;
use App\Models\University;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentRejected implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Student
     */
    public $student;

    /**
     * @var string
     */
    public $reason;

    /**
     * @var University
     */
    public $university;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Student $student, University $university, string $reason)
    {
        $this->student = $student;
        $this->reason = $reason;
        $this->university = $university;
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
