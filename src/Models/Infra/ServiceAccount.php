<?php

namespace Fabrica\Models\Infra;

use Pedreiro\Models\Base;

class ServiceAccount extends Base
{

    protected $organizationPerspective = false;

    protected $table = 'infra_service_accounts';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'infra_service_id',
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


    public function service()
    {
        return $this->belongsTo('Fabrica\Models\Infra\Service', 'infra_service_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\Illuminate\Support\Facades\Config::get('sitec.core.models.user', \App\Models\User::class), 'user_id', 'id');
    }
    
}