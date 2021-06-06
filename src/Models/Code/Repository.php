<?php

/**
 * This file is part of Fabrica.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Fabrica\Models\Code;

use Pedreiro\Models\Base;

class Repository extends Base
{

    public static $apresentationName = 'Repositorys';

    protected $organizationPerspective = true;

    protected $table = 'repositories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name'
    ];

    public function stayInBranchOfAmbiente(Ambiente $ambiente)
    {
        // @todo
        return true;
    }

    public function getApresentationName()
    {
        return 'Numero do Repository';
    }

    public function project()
    {
        return $this->belongsTo('Fabrica\Models\Code\Project', 'code_project_id', 'id');
    }
}
