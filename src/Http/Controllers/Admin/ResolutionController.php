<?php

namespace Fabrica\Http\Controllers\Admin;

use Fabrica\Models\Code\Resolution;
use Fabrica\Services\FabricaService;
use Illuminate\Support\Facades\Schema;
use Pedreiro\CrudController;

class ResolutionController extends Controller
{
    use CrudController;

    public function __construct(Resolution $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
