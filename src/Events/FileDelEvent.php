<?php
namespace Fabrica\Events;

use Fabrica\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class FileDelEvent extends FieldDeleteEvent
{
    use SerializesModels;

    public $file_id;

    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($project_key, $issue_id, $field_key, $file_id, $user)
    {
        $this->project_key = $project_key;
        $this->issue_id = $issue_id;
        $this->field_key = $field_key;
        $this->file_id = $file_id;
        $this->user = $user;
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
