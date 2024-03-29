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

namespace Fabrica\Component\Config;

/**
 * Stores values locally in an array.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class ArrayConfig extends AbstractConfig
{
    /**
     * @var array
     */
    private $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * {@inheritDoc}
     */
    public function doGetAll()
    {
        return $this->values;
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function doSetAll(array $values)
    {
        $this->values = $values;
    }
}
