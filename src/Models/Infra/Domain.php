<?php

namespace Fabrica\Models\Infra;

use Finder\Models\Digital\Internet\Url;
use Support\Models\Base;

class Domain extends Base
{
    public static $apresentationName = 'Dominios';

    protected $organizationPerspective = true;

    protected $table = 'infra_domains';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'status',
        'user_id',
    ];
    
    public $formFields = [
        [
            'name' => 'name',
            'label' => 'name',
            'type' => 'text'
        ],
        [
            'name' => 'url',
            'label' => 'url',
            'type' => 'text'
        ],
        [
            'name' => 'status',
            'label' => 'Status',
            'type' => 'checkbox'
        ],
        // [
        //     'name' => 'status',
        //     'label' => 'Enter your content here',
        //     'type' => 'textarea'
        // ],
        // ['name' => 'publish_on', 'label' => 'Publish Date', 'type' => 'date'],
        // ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'relationship' => 'category'],
        // ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'name',
        'url',
        'status'
    ];

    public $validationRules = [
        'name'       => 'required|max:255',
        'url'        => 'required|max:100',
        'status'        => 'boolean',
        // 'publish_on'  => 'date',
        // 'published'   => 'boolean',
        // 'category_id' => 'required|int',
    ];

    public $validationMessages = [
        'name.required' => "Nome é obrigatório."
    ];

    public $validationAttributes = [
        'name' => 'Name'
    ];
    protected $mappingProperties = array(

        'url' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'status' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'user_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
    );

    public function getApresentationName()
    {
        return $this->url;
    }

    public function getRootPage()
    {
        if (!$url = $this->urls()->first()) {
            $url = Url::create(
                [
                'infra_domain_id' => $this->id,
                'url' => $this->url.'/',
                ]
            );
        }
        return $url;
    }

    public function urls()
    {
        return $this->hasMany('Finder\Models\Digital\Internet\Url', 'infra_domain_id', 'id');
    }
}
