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
 * Stores configuration to a PHP file.
 *
 * If file does not exists, it returns an empty configuration.
 *
 * File is expected to return an array of values.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class PhpFileConfig extends AbstractConfig
{
    /**
     * Fullpath to PHP file
     *
     * @var string
     */
    private $path;

    /**
     * @param string $path Path to the file
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritDoc}
     */
    public function doGetAll()
    {
        if (!file_exists($this->path)) {
            return array();
        }

        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('Unable to read "%s"', $this->path));
        }

        $raw = include $this->path;
        if (!is_array($raw)) {
            throw new \RuntimeException(sprintf('Content of file "%s" is invalid', $this->path));
        }

        return $raw;
    }

    /**
     * {@inheritDoc}
     *
     * @return static
     */
    protected function doSetAll(array $values)
    {
        file_put_contents($this->path, '<?php return '.var_export($values, true).';');
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($this->path);
        }
        $this->values = $values;

        return $this;
    }
}
