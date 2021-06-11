<?php

namespace Fabrica\Entities;


class RepositoryEntity extends EntityAbstract
{
    
    /**
     * Return diretory path
     *
     * @return string
     */
    public function getTargetPath(): string
    {
        return $this->code->getTargetPath();
    }


    public function commits()
    {
        return $this;
    }

    public function attach($commit)
    {

    }
}