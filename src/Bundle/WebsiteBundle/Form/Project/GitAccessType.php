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

class GitAccessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'role', 'entity', array(
            'class' => 'Finder\Models\Code\Role',
            'property' => 'name'
            )
        );
        $builder->add('reference', 'text');
        $builder->add('write', 'checkbox', array('required' => false));
        $builder->add('admin', 'checkbox', array('required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => 'Finder\Models\Code\ProjectGitAccess',
            )
        );
    }

    public function getName()
    {
        return 'project_git_access';
    }
}
