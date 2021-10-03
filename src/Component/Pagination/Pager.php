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

namespace Fabrica\Component\Pagination;

class Pager implements \IteratorAggregate, \Countable
{
    /**
     * @var PagerAdapterInteface
     */
    private $adapter;

    private $offset = 0;
    private $perPage;
    private $total;

    public function __construct(PagerAdapterInterface $adapter, $perPage = 10)
    {
        $this->adapter = $adapter;
        $this->perPage = $perPage;
    }

    public function setOffset($offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return static
     *
     * @param int $page
     */
    public function setPage(int $page): self
    {
        $this->offset = (max(1, (int) $page) - 1) * $this->perPage;

        return $this;
    }

    public function isFirstPage(): bool
    {
        return $this->getPage() == 1;
    }

    public function isLastPage(): bool
    {
        return $this->getPage() == $this->getPageCount();
    }

    public function getPage(): float
    {
        return floor($this->offset/$this->perPage) + 1;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage(int $perPage): void
    {
        $this->perPage = (int) $perPage;
    }

    public function count()
    {
        if (null === $this->total) {
            $this->total = $this->adapter->count();
        }

        return $this->total;
    }

    /**
     * Can be zero.
     *
     * @return float
     */
    public function getPageCount(): float
    {
        return ceil($this->count() / $this->perPage);
    }

    /**
     * @return \Traversable
     */
    public function getResults(): \Traversable
    {
        return $this->getIterator();
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->adapter->get($this->offset, $this->perPage));
    }
}
