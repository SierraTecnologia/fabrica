<?php

use Alex\MailCatcher\Behat\MailCatcherContext;
use Behat\Behat\Context\BehatContext;
use Fabrica\QA\Context\ApiContext;
use Fabrica\QA\Context\FabricaNavigationContext;
use WebDriver\Behat\WebDriverContext;

class FeatureContext extends BehatContext
{
    public function __construct(array $parameters)
    {
        $this->useContext('api', new ApiContext());
        $this->useContext('fabrica_navigation', new FabricaNavigationContext());
        $this->useContext('webdriver', new WebDriverContext());
        $this->useContext('mailcatcher', new MailCatcherContext());
    }
}
