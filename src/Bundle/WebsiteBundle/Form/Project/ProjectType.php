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

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('label' => 'form.information.name'));
        if ('create' === $options['action']) {
            $builder->add('slug', 'text', array('label' => 'form.information.slug'));
        }
        $builder->add('defaultBranch', 'text', array('label' => 'form.information.defaultBranch'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'Siravel\Models\Components\Code\Project',
            'translation_domain' => 'project_admin',
            'action'             => 'create',
        ));
    }

    public function getName()
    {
        return 'project';
    }
}
