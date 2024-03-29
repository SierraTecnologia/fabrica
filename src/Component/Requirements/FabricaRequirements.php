<?php

/**
 * This file is part of Fabrica.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Fabrica\Component\Requirements;

/**
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class FabricaRequirements extends RequirementCollection
{
    public function __construct()
    {
        // PHP Version
        $this->addRequirement(
            version_compare(PHP_VERSION, '5.3.7', '>='),
            'Your PHP must be greater than 5.3.7 ('.PHP_VERSION.' installed)'
        );

        // Git command
        list($gitInstalled, $gitVersion) = $this->findGit();
        $this->addRequirement(
            $gitInstalled && version_compare($gitVersion, '1.7', '>='),
            'Your git must be greater than 1.7 ('.$gitVersion.' installed)'
        );
    }

    /**
     * @return (bool|string)[]
     *
     * @psalm-return array{0: bool, 1: string}
     */
    protected function findGit(): array
    {
        $proc = proc_open(
            'git --version',
            array(
                0 => array('pipe', 'r'),
                1 => array('pipe', 'w'),
                2 => array('pipe', 'w')
            ), $pipes
        );

        $res = preg_match('/^git version ([0-9\.]+)(.+)?\n$/', stream_get_contents($pipes[1]), $vars);
        $rtn = proc_close($proc);
        if (!$res) {
            return array(false, 'none');
        }
        $version = $vars[1];

        return array(true, $version);
    }
}
