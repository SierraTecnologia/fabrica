<?php

namespace Fabrica\Http\Controllers\Master;

use Fabrica\Models\Infra\Computer;
use Pedreiro\CrudController;

class ComputerController extends Controller
{
    use CrudController;

    public function __construct(Computer $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
