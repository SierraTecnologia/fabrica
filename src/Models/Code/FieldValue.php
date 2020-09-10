<?php

namespace Fabrica\Models\Code;

use Finder\Models\Reference;
use Support\Models\Base;

class FieldValue extends Base
{
    protected $organizationPerspective = false;

    protected $table = 'code_issue_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'code_field_code',
        'code_issue_id'
    ];
    
    public $formFields = [
        [
            'name' => 'value',
            'label' => 'value',
            'type' => 'text'
        ],
        [
            'name' => 'code_field_code',
            'label' => 'Field',
            'type' => 'select',
            'relationship' => 'field'
        ],
        [
            'name' => 'code_issue_id',
            'label' => 'Issue',
            'type' => 'select',
            'relationship' => 'issue'
        ],
    ];

    public $indexFields = [
        'value',
        'code_field_code',
        'code_issue_id'
    ];

    public $validationRules = [
        'value'       => 'required',
        'code_field_code'   => 'required',
        'code_issue_id' => 'required|int',
    ];

    public $validationMessages = [
        'value.required' => "Valor é obrigatório."
    ];

    public $validationAttributes = [
        'value' => 'Value'
    ];
    /**
     * 63 => JiraRestApi\Field\Field^ {#472
     * +id: "customfield_10033"
     * +name: "Porque essa funcionalidade deve ser desenvolvida ?"
     * +description: null
     * +type: null
     * +custom: true
     * +orderable: true
     * +navigable: true
     * +searchable: true
     * +searcherKey: null
     * +clauseNames: array:2 [
     *   0 => "cf[10033]"
     *   1 => "Porque essa funcionalidade deve ser desenvolvida ?"
     * ]
     * +schema: {#792
     *   +"type": "string"
     *   +"custom": "com.atlassian.jira.plugin.system.customfieldtypes:textarea"
     *   +"customId": 10033
     * }
     * +"key": "customfield_10033"
     * }
     */
    public static function registerFieldForProject($field, $projectUrl = false)
    {
        dd($field);
        $field =  self::firstOrCreate(
            [
            'name' => $field->name
            ]
        );

        if ($projectUrl) {
            if (!$reference = Reference::where(
                [
                'code' => $projectUrl
                ]
            )->first()
            ) {
                $reference = Reference::create(
                    [
                    'code' => $projectUrl,
                    'name' => $projectUrl,
                    ]
                );
            }
            if (!$field->references()->where('reference_id', $reference->id)->first()) {
                $field->references()->save(
                    $reference,
                    [
                        'identify' => $field->id,
                    ]
                );
            }
        }
        return $field;

        // foreach($comments as $comment) {
        //     var_dump($comment);
        //     Coment::firstOrCreate([
        //         'name' => $comment->name
        //     ]);
        // }
    }
    
    public function references()
    {
        return $this->morphToMany(Reference::class, 'referenceable');
    }
}
