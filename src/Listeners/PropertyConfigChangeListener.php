<?php

namespace Fabrica\Listeners;
use Illuminate\Support\Facades\Event as Event2;

use Fabrica\Events\Event;
use Fabrica\Events\FieldChangeEvent;
use Fabrica\Events\ResolutionConfigChangeEvent;
use Fabrica\Events\PriorityConfigChangeEvent;

use Fabrica\Customization\Eloquent\Field;
use Fabrica\Customization\Eloquent\Resolution;
use Fabrica\Customization\Eloquent\Priority;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PropertyConfigChangeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FieldChangeEvent  $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event instanceof ResolutionConfigChangeEvent)
        {
            $this->updateField('resolution', $event->project_key);
        }
        else if ($event instanceof PriorityConfigChangeEvent)
        {
            $this->updateField('priority', $event->project_key);
        }
    }

    /**
     * update the field.
     *
     * @param  string  $field_key
     * @param  string  $project_key 
     * @return void
     */
    public function updateField($field_key, $project_key)
    {
        $field = Field::whereRaw([ 'key' => $field_key, 'project_key' => $project_key ])->first();
        if (!$field)
        {
            return;
        }
        // get resolution or priority list for optionValues and defaultValue
        $optionValues = []; $defalutValue = '';
        if ($field_key == 'resolution')
        {
            $properties = Resolution::whereRaw([ 'project_key' => $project_key ])->orderBy('sn', 'asc')->get();
        }
        else if ($field_key == 'priority')
        {
            $properties = Priority::whereRaw([ 'project_key' => $project_key ])->orderBy('sn', 'asc')->get();
        }
        else 
        {
            return;
        }
        foreach ($properties as $property)
        {
            $optionValues[] = [ 'id' => $property->id, 'name' => $property->name ];
            if ($property->default)
            {
                $defaultValue = $property->id;
            }
        }
        $field->optionValues = $optionValues ?: [];
        $field->defaultValue = $defaultValue ?: '';
        $field->save();

        Event2::fire(new FieldChangeEvent($field->id));
    }
}
