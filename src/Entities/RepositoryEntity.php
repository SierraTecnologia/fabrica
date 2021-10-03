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


    /**
     * @return static
     */
    public function commits(): self
    {
        return $this;
    }

    public function attach($commit): void
    {

    }
}