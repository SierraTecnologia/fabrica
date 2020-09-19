<?php

namespace Fabrica\Http\Controllers\Painel;

use Fabrica\Models\Code\Project;
use Fabrica\Services\FabricaService;
use Illuminate\Support\Facades\Schema;
use Pedreiro\CrudController;

class ProjectController extends Controller
{
    use CrudController;

    public function __construct(Project $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
