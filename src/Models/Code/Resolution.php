<?php

namespace Fabrica\Models\Code;

use Support\Models\Base;

class Resolution extends Base
{
    protected $organizationPerspective = false;

    protected $table = 'code_resolutions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
        
    public $formFields = [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text'],
        ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
        ['name' => 'body', 'label' => 'Enter your content here', 'type' => 'textarea'],
        ['name' => 'publish_on', 'label' => 'Publish Date', 'type' => 'date'],
        ['name' => 'published', 'label' => 'Published', 'type' => 'checkbox'],
        ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'relationship' => 'category'],
        ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'title',
        'category_id',
        'published'
    ];

    public $validationRules = [
        'title'       => 'required|max:255',
        'slug'        => 'required|max:100',
        'body'        => 'required',
        'publish_on'  => 'date',
        'published'   => 'boolean',
        'category_id' => 'required|int',
    ];

    public $validationMessages = [
        'body.required' => "You need to fill in the post content."
    ];

    public $validationAttributes = [
        'title' => 'Post title'
    ];
}
