<?php

namespace Fabrica\Models\Workflow;

use Pedreiro\Models\Base;

class Transaction extends Base
{

    protected $organizationPerspective = false;

    protected $table = 'workflow_transactions';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'workflow_id',
        'stage_from_id',
        'stage_to_id',
    ];


    protected $mappingProperties = array(

        'workflow_id' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'stage_from_id' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'stage_to_id' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );


    public function workflow()
    {
        return $this->belongsTo('Fabrica\Models\Workflow\Workflow', 'table_id', 'id');
    }

    public function stageFrom()
    {
        return $this->belongsTo('Finder\Models\Code\Stage', 'table_id', 'id');
    }

    public function stageTo()
    {
        return $this->belongsTo('Finder\Models\Code\Stage', 'table_id', 'id');
    }
}