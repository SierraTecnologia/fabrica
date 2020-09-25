<?php

namespace Fabrica\Http\Controllers\Admin;

use Fabrica\Models\Code\Field;
use Fabrica\Models\Code\Project;

use Fabrica\Models\Code\Wiki;
use Fabrica\Models\Infra\Container;
use Fabrica\Models\Infra\Domain;


use Fabrica\Services\FabricaService;
use Illuminate\Support\Facades\Schema;


use Informate\Models\Entytys\Fisicos\Weapon;
use Integrations\Models\Token;
use Population\Models\Features\Qa\Analyser;


use Telefonica\Models\Actors\Business;
use Telefonica\Models\Actors\Person;



use Telefonica\Models\Digital\Account;

class ArquiteturaController extends Controller
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

        //Domain
        

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
