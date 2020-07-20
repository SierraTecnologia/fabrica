<?php

namespace Fabrica\Entitys;


class DirectoryEntity extends EntityAbstract
{
    public $files = [];
    public $directorys = [];
    
    /**
     * Return diretory path
     *
     * @return string
     */
    public function getTargetPath(): string
    {
        return $this->code;
    }

    public function isProject(): bool
    {
        if (file_exists($this->getTargetPath().'/.git')) {
            return true;
        }
        if (file_exists($this->getTargetPath().'/.gitignore')) {
            return true;
        }
        if (file_exists($this->getTargetPath().'/pubspec.yaml')) {
            return true;
        }
        if (file_exists($this->getTargetPath().'/composer.json')) {
            return true;
        }
        if (file_exists($this->getTargetPath().'/package.json')) {
            return true;
        }

        return false;
    }
}