<?php

namespace Fabrica\Models\Code;

use Support\Models\Base;

class Status extends Base
{

    protected $organizationPerspective = false;

    protected $table = 'code_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    
}