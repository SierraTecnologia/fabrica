<?php

namespace Fabrica\Tools;

/**
 * Bash Class
 *
 * @class Bash
 */
class Bash
{

    protected $localDir = false;

    public function __construct($localDir = false)
    {
        $this->localDir = $localDir;
        if (!$this->localDir) {
            $this->localDir = storage_path().DS.'tools'.DS;
        }
    }

    public function hasProgram($program)
    {
        $hasProgram = $this->exec($this->typeProgramString($program));
        var_dump($hasProgram);
        if (is_null($hasProgram) || empty($hasProgram)) {
            return false;
        }
        return true;
    }

    public function typeProgramString($program)
    {
        return 'type -P '.$program;
    }

    public function exec($exec, $sudo = false)
    {
        if ($sudo) {
            $exec = 'sudo '.$exec;
        }
        return shell_exec('cd '.$this->localDir.' && '.$exec);
    }
}
