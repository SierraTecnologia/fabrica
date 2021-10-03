<?php

namespace Fabrica\Bundle\DistributionBundle\Installation\Step;

use Fabrica\Bundle\DistributionBundle\Installation\StepInterface;

class SecretStep implements StepInterface
{
    /**
     * @return int
     *
     * @psalm-return 0|1
     */
    public function getStatus(array $parameters)
    {
        foreach (array('secret', 'remember_secret') as $key) {
            if ($parameters[$key] == 'ThisTokenIsNotSoSecretChangeIt') {
                return self::STATUS_ERROR;
            }
        }

        return self::STATUS_OK;
    }

    /**
     * @return string
     *
     * @psalm-return 'secret'
     */
    public function getSlug()
    {
        return 'secret';
    }

    public function getName(): string
    {
        return 'Secret';
    }

    /**
     * @return string
     *
     * @psalm-return 'FabricaDistributionBundle:Configuration:step_secret.html.twig'
     */
    public function getTemplate()
    {
        return 'FabricaDistributionBundle:Configuration:step_secret.html.twig';
    }

    /**
     * @return string
     *
     * @psalm-return 'installation_step_secret'
     */
    public function getForm()
    {
        return 'installation_step_secret';
    }
}
