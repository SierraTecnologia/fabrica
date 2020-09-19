<?php

namespace Fabrica\Events;

use Fabrica\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class DelGroupFromRoleEvent extends Event
{
    use SerializesModels;

    public $group_ids;

    public $project_key;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($group_ids, $project_key)
    {
        $this->group_ids = $group_ids;
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
