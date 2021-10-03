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

namespace Fabrica\Component\Config\Tests;

use Doctrine\DBAL\Driver\PDOSqlite\Driver as SqliteDriver;
use Doctrine\DBAL\Connection;

use Fabrica\Component\Config\MysqlConfig;

/**
 * Tests of MySQL configuration are achieved with a SQLite database.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class MysqlConfigTest extends \PHPUnit\Framework\TestCase
{
    public function testAbstract(): void
    {
        $path = $this->tempFile();
        $configA = $this->createConfig($path);

        $configA->setAll(array('foo' => 'bar', 'bar' => 'baz'));

        $configB = $this->createConfig($path);
        $this->assertEquals('bar', $configB->get('foo'));
        $this->assertEquals('baz', $configB->get('bar'));

        unlink($path);
    }

    /**
     * @param false|string $path
     */
    protected function createConfig($path): MysqlConfig
    {
        $conn = new Connection(array('path' => $path), new SqliteDriver());

        return new MysqlConfig($conn);
    }

    /**
     * @return false|string
     */
    protected function tempFile()
    {
        $file = tempnam(sys_get_temp_dir(), 'fabrica_');
        unlink($file);

        return $file;
    }
}
