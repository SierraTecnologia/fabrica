<?php

namespace Fabrica\Models\Code;

use Pedreiro\Models\Base;

class Stage extends Base
{
    protected $organizationPerspective = false;

    protected $table = 'code_stages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
