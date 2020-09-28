<?php

namespace Fabrica\Models\Infra;

use Pedreiro\Models\Base;

class Hook extends Base
{

    protected $organizationPerspective = true;

    protected $table = 'infra_hooks';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model', // Project
        'model_id',
        'credit_card_id',
        'user_id',
    ];


    protected $mappingProperties = array(

        'customer_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'credit_card_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'user_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'docker_compose_file' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );


    public function user()
    {
        return $this->belongsTo(\Illuminate\Support\Facades\Config::get('application.directorys.models.users', \App\Models\User::class), 'user_id', 'id');
    }

}