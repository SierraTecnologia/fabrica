<?php

namespace Fabrica\Http\Controllers\Painel;

use Finder\Models\Code\Issue;
use Pedreiro\CrudController;

class IssueController extends Controller
{
    use CrudController;

    public function __construct(Issue $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
