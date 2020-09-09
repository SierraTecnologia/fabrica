<?php
namespace Fabrica\Events;
use Fabrica\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IssueEvent extends Event
{
    use SerializesModels;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($project_key, $issue_id, $user, $param=[])
    {
        $this->project_key   = $project_key;
        $this->issue_id      = $issue_id;
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
