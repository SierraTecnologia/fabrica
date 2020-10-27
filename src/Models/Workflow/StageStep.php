<?php

namespace Fabrica\Models\Workflow;

use Pedreiro\Models\Base;

class StageStep extends Base
{

    protected $organizationPerspective = false;

    protected $table = 'stage_steps';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'color',
    ];


    protected $mappingProperties = array(

        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'color' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

}