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

namespace Fabrica\Component\Pagination\Adapter;

use Fabrica\Component\Pagination\PagerAdapterInterface;

class ArrayAdapter implements PagerAdapterInterface
{
    private $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @return int
     *
     * @psalm-return 0|positive-int
     */
    public function count()
    {
        return count($this->array);
    }

    /**
     * @return array
     *
     * @param int $offset
     * @param int $limit
     */
    public function get(int $offset, int $limit)
    {
        return array_slice($this->array, $offset, $limit);
    }
}
