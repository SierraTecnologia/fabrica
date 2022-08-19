<?php

namespace Fabrica\Models\Planning;

use Pedreiro\Models\Base;

class Sprint extends Base
{

    protected $organizationPerspective = false;

    protected $table = 'sprints';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'init',
        'end',
        'order',
    ];


    protected $mappingProperties = array(

        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );


    // public function stage()
    // {
    //     return $this->belongsTo('Finder\Models\Code\Stage', 'stage_id', 'id');
    // }
    // public function stages()
    // {
    //     return $this->belongsToMany('Finder\Models\Code\Stage', 'workflow_stages', 'workflow_id', 'stage_id');
    // }
}