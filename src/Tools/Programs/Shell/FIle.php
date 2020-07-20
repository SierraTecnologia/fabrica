<?php

namespace App\Task\External\Shell;

/**
 * Ln Criar Link Simbolico
 */

class File
{
    protected $path = false;

    protected $directory = false;
    
    public function isDirectory()
    {
        return $this->directory;
    }
    
    public function link($target)
    {
        return 'ln -s '.$this->path.' '.$target;
    }
    
    public function move($target)
    {
        return 'mv '.$this->path.' '.$target;
    }
    
    public function copy($target)
    {
        $options = '';

        if ($this->isDirectory()) {
            $options = ' -r';
        }

        return 'cp '.$this->path.' '.$target.$options;
    }
}