<?php

namespace Fabrica\Http\Controllers\Admin;

use Fabrica\Models\Code\Status;
use Fabrica\Services\FabricaService;
use Illuminate\Support\Facades\Schema;
use Pedreiro\CrudController;

class StatusController extends Controller
{
    use CrudController;

    public function __construct(Status $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
