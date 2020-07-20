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

namespace Fabrica\Bundle\CoreBundle\Validation\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\Bundle\DoctrineBundle\Registry;

class NewEmailValidator extends ConstraintValidator
{
    /**
     * @var Symfony\Bundle\DoctrineBundle\Registry
     */
    protected $doctrineRegistry;

    public function __construct(Registry $doctrineRegistry)
    {
        $this->doctrineRegistry = $doctrineRegistry;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$value) {
            return;
        }

        $email = $this->doctrineRegistry->getRepository('FabricaCoreBundle:Email')->findOneByEmail($value);
        if ($email) {
            $this->context->addViolation($constraint->message);
        }
    }
}
