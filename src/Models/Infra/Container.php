<?php
/**
 * Servidor de Database
 */

namespace Fabrica\Models\Infra;

use Pedreiro\Models\Base;

class Container extends Base
{

    protected $organizationPerspective = true;

    protected $table = 'containers';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
    ];


    protected $mappingProperties = array(

        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'image' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );
}