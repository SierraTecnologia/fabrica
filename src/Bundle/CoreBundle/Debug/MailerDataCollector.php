<?php

namespace Fabrica\Bundle\CoreBundle\Debug;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

use Fabrica\Bundle\CoreBundle\Mailer\DebugMailer;

class MailerDataCollector extends DataCollector
{
    protected $mailer;

    public function __construct(DebugMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @return void
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'count' => $this->mailer->getMessageCount()
        );
    }

    public function getName()
    {
        return 'mailer';
    }

    public function getMessageCount()
    {
        return isset($this->data['count']) ? $this->data['count'] : 0;
    }
}
