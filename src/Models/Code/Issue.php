<?php

namespace Fabrica\Models\Code;

use Fabrica\Models\Code\Project;
use Finder\Models\Reference;
use Illuminate\Support\Str;
use StdClass;
use Pedreiro\Models\Base;

class Issue extends Base
{
    protected $organizationPerspective = true;

    protected $table = 'code_issues';

    protected $action = false;

    protected $target = false;

    protected $worker = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'key_name',
        'slug',
        'url',
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

    public function project()
    {
        return $this->belongsTo(Project::class, 'code_project_id', 'id');
    }

    public function setField($fields, $issueKey)
    {
        // @todo fazer aqui
        foreach ($fields as $fieldIdentify=>$result) {
            if (is_a($result, StdClass::class)) {
            }

            if (Str::start($fieldIdentify, 'customfield')) {
                // @todo
                // dd($fieldIdentify, $result); $field = Field::firstOrCreate([
                //     'code' => $fieldIdentify
                // ]);
                FieldValue::create(
                    [
                    'value' => $fieldIdentify,
                    'code_field_code' => $fieldIdentify,
                    'code_issue_id' => $issueKey,
                    ]
                );
            } elseif ($fieldIdentify == 'lastViewed') {
            } elseif ($fieldIdentify == 'resolutiondate') {
            } else {
                var_dump(
                    [
                        'IssueModel',
                        $fieldIdentify,
                        $result
                    ]
                );
            }
        }
    }
}
