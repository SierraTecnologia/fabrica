<?php

namespace Fabrica\Http\Controllers\Admin;

use Fabrica\Models\Code\Stage;
use Fabrica\Services\FabricaService;
use Illuminate\Support\Facades\Schema;
use Pedreiro\CrudController;

class StageController extends Controller
{
    use CrudController;

    public function __construct(Stage $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
