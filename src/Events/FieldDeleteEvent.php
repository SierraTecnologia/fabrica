<?php

namespace Fabrica\Events;

use Fabrica\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class FieldDeleteEvent extends FieldChangeEvent
{
    use SerializesModels;

    public $project_key;

    public $field_key;

    public $field_type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($project_key, $field_id, $field_key, $field_type)
    {
        $this->project_key = $project_key;
        $this->field_id = $field_id;
        $this->field_key = $field_key;
        $this->field_type = $field_type;
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
