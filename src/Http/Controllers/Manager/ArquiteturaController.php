<?php

namespace Fabrica\Http\Controllers\Manager;

use Fabrica\Services\FabricaService;
use Illuminate\Support\Facades\Schema;

use Fabrica\Models\Code\Field;
use Fabrica\Models\Infra\Domain;
use Fabrica\Models\Infra\Container;


use Telefonica\Models\Actors\Business;
use Telefonica\Models\Actors\Person;


use Fabrica\Models\Code\Project;
use Fabrica\Models\Code\Wiki;
use Population\Models\Features\Qa\Analyser;


use Telefonica\Models\Digital\Account;
use Integrations\Models\Token;



use Informate\Models\Entytys\Fisicos\Weapon;

class ArquiteturaController extends Controller
{
    protected $service;

    public function __construct(FabricaService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    public function index()
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
