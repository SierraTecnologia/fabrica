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

namespace Fabrica\Bundle\WebsiteBundle\Form\Project;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $users     = $options['usedUsers'];
        $usedUsers = array();
        foreach ($users as $user) {
            $usedUsers[] = $user->getId();
        }

        $builder->add(
            'user', 'entity', array(
            'class'   => 'Finder\Models\Code\User',
            'property' => 'fullname',
            'query_builder' => function (EntityRepository $er) use ($usedUsers) {
                $query = $er
                    ->createQueryBuilder('U')
                    ->orderBy('U.fullname', 'ASC');
                if (count($usedUsers) > 0) {
                    $query
                        ->where('U.id NOT IN (:userIds)')
                        ->setParameter('userIds', $usedUsers);
                }

                return $query;
            },
            )
        );

        $builder
            ->add(
                'role', 'entity', array(
                'class'   => 'Finder\Models\Code\Role',
                'property' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    $query = $er
                        ->createQueryBuilder('R')
                        ->where('R.isGlobal = false')
                        ->orderBy('R.name', 'ASC');

                    return $query;
                },
                )
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class'   => 'Finder\Models\Code\UserRoleProject',
            'usedUsers'    => array(),
            'from'         => null,
            )
        );
    }

    public function getName()
    {
        return 'project_role';
    }
}
