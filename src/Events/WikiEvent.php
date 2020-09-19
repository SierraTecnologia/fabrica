<?php
namespace Fabrica\Events;

use Fabrica\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class WikiEvent extends Event
{
    use SerializesModels;

    public $project_key;

    public $user;

    public $param;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($project_key, $user, $param=[])
    {
        $this->project_key   = $project_key;
        $this->user          = $user;
        $this->param         = $param;
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
