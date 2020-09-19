<?php

namespace Fabrica\Events;

use Fabrica\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class FieldChangeEvent extends Event
{
    use SerializesModels;

    public $field_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($field_id)
    {
        $this->field_id = $field_id;
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
