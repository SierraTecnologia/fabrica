<?php

namespace Fabrica\Models\Code;

use Support\Models\Base;
use Finder\Models\Reference;
use Fabrica\Models\Code\Project;
use StdClass;
use Illuminate\Support\Str;

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
                FieldValue::create([
                    'value' => $fieldIdentify,
                    'code_field_id' => $fieldIdentify,
                    'code_issue_id' => $issueKey,
                ]);
            } else if ($fieldIdentify == 'lastViewed') {
                
            } else if ($fieldIdentify == 'resolutiondate') {

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