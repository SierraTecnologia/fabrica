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

namespace Fabrica\Bundle\JobBundle\Job;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Job implements JobInterface, ContainerAwareInterface
{
    private $id;
    private $parameters;
    private $container;

    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return static
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     */
    public function getParameter(string $name, $default = null)
    {
        return array_key_exists($name, $this->parameters) ? $this->parameters[$name] : $default;
    }

    protected function getContainer()
    {
        if (!$this->container) {
            throw new \RuntimeException('Container not injected in job.');
        }

        return $this->container;
    }

    /**
     * @param string $id
     */
    protected function getService(string $id)
    {
        return $this->getContainer()->get($id);
    }
}
