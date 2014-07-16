<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
        $builder->add('startDate', 'date', ['required' => false, 'widget' => 'single_text']);
        $builder->add('endDate', 'date', ['required' => false, 'widget' => 'single_text']);
        $builder->setMethod('GET');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    public function getName()
    {
        return 'user_search';
    }
}
