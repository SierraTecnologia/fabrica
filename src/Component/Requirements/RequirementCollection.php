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
class RequirementCollection
{
    protected $requirements;

    public function __construct(array $requirements)
    {
        $this->requirements = $requirements;
    }

    public function isValid(): bool
    {
        foreach ($this->requirements as $requirement) {
            if (!$requirement->isValid()) {
                return false;
            }
        }

        return true;
    }

    public function addRequirement(bool $isValid, string $requirement): void
    {
        $this->requirements[] = new Requirement($isValid, $requirement);
    }

    public function getErrors(): array
    {
        return array_filter(
            $this->requirements, function ($requirement) {
                return !$requirement->isValid();
            }
        );
    }
}
