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

namespace Fabrica\Component\Pagination\Tests;

use Fabrica\Component\Pagination\Pager;
use Fabrica\Component\Pagination\Adapter\ArrayAdapter;

class PagerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param int|string[] $value
     */
    private function createPager($value): Pager
    {
        if (is_array($value)) {
            $array = $value;
        } else {
            $array = (array) new \SplFixedArray($value);
        }

        return new Pager(new ArrayAdapter($array));
    }

    public function testEmpty(): void
    {
        $pager = $this->createPager(0);

        $this->assertEquals(0, $pager->count(),        "Empty pager returns 0 elements");
        $this->assertEquals(0, $pager->getPageCount(), "Empty pager returns 0 pages");
        $this->assertEquals(0, $pager->getOffset(),    "Offset is 0 by default");
        $this->assertEquals(1, $pager->getPage(),      "Default to first page");
    }

    public function testSimple(): void
    {
        $pager = $this->createPager(array('a', 'b', 'c', 'd'));

        $pager->setPerPage(2);
        $pager->setPage(1);
        $this->assertEquals(array('a', 'b'), (array) $pager->getIterator());
        $pager->setPage(2);
        $this->assertEquals(array('c', 'd'), (array) $pager->getIterator());

        $pager->setPerPage(1);
        $pager->setPage(1);
        $this->assertEquals(array('a'), (array) $pager->getIterator());
        $pager->setPage(2);
        $this->assertEquals(array('b'), (array) $pager->getIterator());
        $pager->setPage(4);
        $this->assertEquals(array('d'), (array) $pager->getIterator());
    }

    public function testPerPage(): void
    {
        $pager = $this->createPager(54);
    }

    /**
     * @return int[][]
     *
     * @psalm-return array{0: array{0: 0, 1: 0}, 1: array{0: 1, 1: 1}, 2: array{0: 29, 1: 3}, 3: array{0: 30, 1: 3}, 4: array{0: 31, 1: 4}}
     */
    public function provideRoundingPagination(): array
    {
        return array(
            array(0,  0),
            array(1,  1),
            array(29, 3),
            array(30, 3),
            array(31, 4)
        );
    }

    /**
     * @dataProvider provideRoundingPagination
     *
     * @return void
     */
    public function testRoundingPagination($count, $pageCount): void
    {
        $pager = $this->createPager($count);

        $this->assertEquals($count,     $pager->count(),        "Global counting");
        $this->assertEquals($pageCount, $pager->getPageCount(), "Count of pages");
    }
}
