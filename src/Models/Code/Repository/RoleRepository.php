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

namespace Fabrica\Models\Code\Repository;

use Doctrine\ORM\EntityRepository;
use Fabrica\Models\Code;

class RoleRepository extends EntityRepository
{
    public function getIndexedByName($names)
    {
        $qb = $this->createQueryBuilder('r');
        $res = $qb->where($qb->expr()->in('r.name', $names))->getQuery()->execute();

        $return = array();
        foreach ($res as $role) {
            $return[$role->getName()] = $role;
        }

        return $return;
    }
}
