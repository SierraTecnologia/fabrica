<?php

namespace Fabrica\Models\Code;

use Pedreiro\Models\Base;

class Stage extends Base
{
    protected $organizationPerspective = false;

    protected $table = 'code_stages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'stage_step_id'
    ];

    public $formFields = [
        [
            'name' => 'name',
            'label' => 'Nome',
            'type' => 'text'
        ],
        [
            'name' => 'stage_step_id',
            'label' => 'Tipo',
            'type' => 'select',
            'relationship' => 'stageStep'
        ],
    ];

    public $indexFields = [
        'name',
        'stage_step_id'
    ];
    
    public function stageStep()
    {
        return $this->belongsTo('Fabrica\Models\Workflow\StageStep', 'stage_step_id', 'id');
    }

    public function workflows()
    {
        return $this->hasMany('Fabrica\Models\Workflow\Workflow');
    }
}
