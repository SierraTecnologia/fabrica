<?php

namespace Fabrica\Models\Infra;

use Support\Models\Base;
use Fabrica\Tools\Ssh;

class Computer extends Base
{

    public static $apresentationName = 'Servidores';

    protected $organizationPerspective = true;

    protected $table = 'infra_computers';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'infra_service_account_id',
        'infra_ambiente_id',
        'infra_ssh_key_id',
    ];


    protected $mappingProperties = array(

        'customer_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'infra_ssh_key_id' => [
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

    public function getName()
    {
        return $this->instance;
    }

    public function getApresentationName()
    {
        if (!$name = $this->getName()) {
            return 'Vazio';
        }
        return $name;
    }

    public function connect()
    {
        return new Ssh($this);
    }


    public function user()
    {
        return $this->belongsTo(\Illuminate\Support\Facades\Config::get('sitec.core.models.user', \App\Models\User::class), 'user_id', 'id');
    }

}