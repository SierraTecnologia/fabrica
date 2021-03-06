<?php

namespace Fabrica\Bundle\DistributionBundle\Installation\Step;

use Fabrica\Bundle\DistributionBundle\Installation\StepInterface;

class SecretStep implements StepInterface
{
    public function getStatus(array $parameters)
    {
        foreach (array('secret', 'remember_secret') as $key) {
            if ($parameters[$key] == 'ThisTokenIsNotSoSecretChangeIt') {
                return self::STATUS_ERROR;
            }
        }

        return self::STATUS_OK;
    }

    public function getSlug()
    {
        return 'secret';
    }

    public function getName()
    {
        return 'Secret';
    }

    public function getTemplate()
    {
        return 'FabricaDistributionBundle:Configuration:step_secret.html.twig';
    }

    public function getForm()
    {
        return 'installation_step_secret';
    }
}
