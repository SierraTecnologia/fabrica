<?php

namespace App\Task\External\Shell;

/**
 * Ln Criar Link Simbolico
 */

class Docker
{
    protected $path = false;

    protected $directory = false;
    
    public function isDirectory()
    {
        return $this->directory;
    }
    
    /**
     *  Isto irá remover imagens não marcadas (com tag `<none>`), 
     *  que são as folhas da árvore de imagens (não camadas intermediárias).
     */
    public function forceRemoveImages($target)
    {
        return 'docker rmi $(docker images -q -f "dangling=true")';
    }
    
    //Para remover todas as images acrescente a opção “-a” ou “–all”.
    public function move($target)
    {
        return 'docker rmi $(docker images -q -a)';
    }
    
    //
    //  Para remover todas as images incluindo as que estão sendo utilizadas por containers acrescente a opção “-f” ou “–force” após o comando “rmi”.
    public function forceRemove($target)
    {
        return 'docker rmi -f $(docker images -q -a)';
    }

    //Para remover apenas containers completos.
    public function completeRemove($target)
    {
        return 'docker rm $(docker ps -q -f "status=exited")';
    }

    //Para remover todos os containers, incluindo os que estão rodando.
    public function forceRemoveAllCntaneirs($target)
    {
        return 'docker rm -f $(docker ps -q -a)';
    }
}