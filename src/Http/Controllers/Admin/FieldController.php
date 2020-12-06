<?php

namespace Fabrica\Http\Controllers\Admin;

use Fabrica\Models\Code\Field;
use Fabrica\Services\FabricaService;
use Illuminate\Support\Facades\Schema;
use Pedreiro\CrudController;

class FieldController extends Controller
{
    use CrudController;


    /**
     * The HTML title, shown in header of the vie. Ex: News Posts
     *
     * @var string
     */
    public $title;

    /**
     * The text description of what this controller manages, shown in the header.
     * Ex: "Relevant news about the brand"
     *
     * @var string
     */
    public $description;

    public function __construct(Field $model)
    {
        $this->model = $model;
        parent::__construct();
    }


    // public function index(Request $request)
    // {
    //     // $service = $this->service;

    //     $service = new \Support\Services\RepositoryService(new \Support\Services\ModelService(Field::class));
    //     $registros = $service->getTableData();
    //     //     $teams = $this->repositoryService->paginated($request->user()->id);

        

    //     return view(
    //         'support::components.repositories.index',
    //         compact('service', 'registros')
    //     );

    //     // return view(
    //     //     'casa::finances.index',
    //     //     compact('service')
    //     // );
    // }
}
