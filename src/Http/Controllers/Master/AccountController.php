<?php

namespace Telefonica\Http\Controllers\Master;

use Telefonica\Models\Digital\Account;
use Pedreiro\CrudController;

class AccountController extends Controller
{
    use CrudController;

    public function __construct(Account $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
