<?php

namespace Fabrica\Events;

use Fabrica\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class DelGroupEvent extends Event
{
    use SerializesModels;

    public $group_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($group_id)
    {
        $this->group_id = $group_id;
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
