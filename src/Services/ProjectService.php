<?php
/**
 * @todo
 */
namespace Fabrica\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Fabrica\Repositories\ProjectRepository;
use Fabrica\Models\Project;
use Muleta\Utils\Modificators\StringModificator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    public function __construct(
        ProjectRepository $projectRepository
    ) {
        $this->repo = $projectRepository;
    }

    /**
     * @todo Terminar de Fazer
     *
     * @return true
     */
    public static function import($data): bool
    {   
        $registerData = $data;
        // if (isset($data['Nome Completo'])) {
        //     $registerData['name'] = $data["Nome Completo"];
        // }
        // if (isset($data['CPF'])) {
        //     $registerData['cpf'] = $data["CPF"];
        // }
        // if (isset($data['Nascimento'])) {
        //     $registerData['birthday'] = $data["Nascimento"];
        // }
        $code = $registerData['code'] = StringModificator::cleanCodeSlug($registerData['name']);

        if (Project::find($code)) {
            return true;
        }
        $project = Project::createIfNotExistAndReturn($registerData);
        return true;
    }
}
