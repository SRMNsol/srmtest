<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email')
            ->add('startDate', 'date', ['required' => false, 'widget' => 'single_text'])
            ->add('endDate', 'date', ['required' => false, 'widget' => 'single_text'])
            ->setMethod('GET')
        ;
    }

    public function getName()
    {
        return 'userSearch';
    }
}
