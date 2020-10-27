<?php

namespace Fabrica\Models\Workflow;

use Pedreiro\Models\Base;

class WorkflowItemType extends Base
{

    protected $organizationPerspective = false;

    protected $table = 'workflow_item_types';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model',
        'filter',
    ];


    protected $mappingProperties = array(

        'model' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'filter' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

}