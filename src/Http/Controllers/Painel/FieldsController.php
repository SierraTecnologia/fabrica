<?php

namespace Fabrica\Http\Controllers\Painel;

use Fabrica\Services\FabricaService;
use Illuminate\Support\Facades\Schema;

use Fabrica\Models\Code\Field;

class FieldsController extends Controller
{
    protected $service;

    public function __construct(FabricaService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    public function index(Request $request)
    {
        // $service = $this->service;

        $service = new \Support\Services\RepositoryService(new \Support\Services\ModelService(Field::class));
        $registros = $service->getTableData();
        //     $teams = $this->repositoryService->paginated($request->user()->id);

        

        return view(
            'support::components.repositories.index',
            compact('service', 'registros')
        );

        // return view(
        //     'casa::finances.index',
        //     compact('service')
        // );
    }
}
