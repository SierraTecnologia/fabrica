<?php

namespace Fabrica\Events;

use Fabrica\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ResolutionConfigChangeEvent extends Event
{
    use SerializesModels;

    public $project_key;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($project_key)
    {
        $this->project_key = $project_key;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
