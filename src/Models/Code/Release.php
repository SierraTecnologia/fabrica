<?php

namespace Fabrica\Models\Code;

use Pedreiro\Models\Base;

class Release extends Base
{
    protected $organizationPerspective = true;

    protected $table = 'code_releases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'status',
        'start',
        'release',
        'code_project_id',
    ];
    
    
    public $formFields = [
        ['name' => 'name', 'label' => 'name', 'type' => 'text'],
        ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
        ['name' => 'release', 'label' => 'Publish Release', 'type' => 'date'],
        ['name' => 'start', 'label' => 'Publish Date', 'type' => 'date'],
        ['name' => 'status', 'label' => 'Published', 'type' => 'checkbox'],
        ['name' => 'code_project_id', 'label' => 'Projeto', 'type' => 'select', 'relationship' => 'project'],
        // ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'name',
        'start',
        'code_project_id',
        'status'
    ];

    public $validationRules = [
        'name'       => 'required|max:255',
        'slug'        => 'required|max:100',
        'release'        => 'required',
        'start'  => 'date',
        'status'   => 'boolean',
        'code_project_id' => 'required|int',
    ];

    public $validationMessages = [
        'name.required' => "Nome é obrigatório."
    ];

    public $validationAttributes = [
        'name' => 'name'
    ];
}
