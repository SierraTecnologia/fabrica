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

use Fabrica\Component\Config\PhpFileConfig;

/**
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class PhpFileConfigTest extends \PHPUnit\Framework\TestCase
{
    public function testInexisting(): void
    {
        $file = $this->getTempFile();

        $storage = new PhpFileConfig($file);

        $value = $storage->get('foo');
        $this->assertNull($value, "Returns null if not present");

        $value = $storage->get('foo', false);
        $this->assertFalse($value, "Returns the default argument");

        $value = $storage->all();
        $this->assertEquals(array(), $value, "Returns the default argument");

        $this->assertFalse(file_exists($file), "No file created (read-only)");
    }

    /**
     * @expectedException RuntimeException
     *
     * @return void
     */
    public function testInvalid(): void
    {
        $file = $this->getTempFile();
        file_put_contents($file, '<?php return 1;');

        $storage = new PhpFileConfig($file);
        $storage->get('foo');
    }

    /**
     * @expectedException RuntimeException
     *
     * @return void
     */
    public function testUnreadable(): void
    {
        $file = $this->getTempFile();
        touch($file);
        chmod($file, 0200);

        $storage = new PhpFileConfig($file);
        $storage->get('foo');
    }

    public function testWritable(): void
    {
        $file = $this->getTempFile();
        $a = new PhpFileConfig($file);
        $a->set('foo', 'bar');

        $b = new PhpFileConfig($file);
        $this->assertEquals('bar', $b->get('foo'));
    }

    /**
     * @return false|string
     */
    private function getTempFile()
    {
        $file = tempnam(sys_get_temp_dir(), 'fabricatest_');
        unlink($file);

        return $file;
    }
}
