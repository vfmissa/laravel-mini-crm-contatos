<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class ContactScoreEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $contactId;
    public int $score;
    public string $status;

    public function __construct(int $contactId, int $score, string $status)
    {
        $this->contactId = $contactId;
        $this->score = $score;
        $this->status = $status;
    }


    public function broadcastOn(): Channel
    {
        return new Channel('contacts.' . $this->contactId);
    }

    public function broadcastAs(): string
    {
        return 'ContactScoreProcessed';
    }

    public function broadcastWith(): array
    {
        return [
            'contactId' => $this->contactId,
            'score'     => $this->score,
            'status'    => 'PROCESSED'
        ];
    }
}