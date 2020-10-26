<?php

namespace Fabrica\Models\Workflow;

use Pedreiro\Models\Base;

class Workflow extends Base
{

    protected $organizationPerspective = false;

    protected $table = 'workflows';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];


    protected $mappingProperties = array(

        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );


    public function stage()
    {
        return $this->belongsTo('Fabrica\Models\Code\Stage', 'stage_id', 'id');
    }
    public function stages()
    {
        return $this->belongsToMany('Fabrica\Models\Code\Stage', 'workflow_stages', 'workflow_id', 'stage_id');
    }
}