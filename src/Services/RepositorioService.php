<?php
/**
 * @todo
 */
namespace Fabrica\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Fabrica\Repositories\RepositorioRepository;
use Fabrica\Models\Repositorio;
use Muleta\Utils\Modificators\StringModificator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RepositorioService
{
    // public function __construct(
    //     RepositorioRepository $repositorioRepository
    // ) {
    //     $this->repo = $repositorioRepository;
    // }

    /**
     * @todo Terminar de Fazer
     *
     * @return true
     */
    public static function import($data): bool
    {   
        $registerData = $data;
        dd($data);
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

        if (Repositorio::find($code)) {
            return true;
        }
        $repositorio = Repositorio::createIfNotExistAndReturn($registerData);
        return true;
    }
}
