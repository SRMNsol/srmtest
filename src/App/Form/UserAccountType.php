<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use App\Entity\User;

class UserAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
        $builder->add('alias');
        $builder->add('firstName', 'text', [
            'required' => false,
        ]);
        $builder->add('address');
        $builder->add('city');
        $builder->add('state');
        $builder->add('zip');
        $builder->add('status', 'choice', [
            'choices' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE]
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\User',
        ]);
    }

    public function getName()
    {
        return 'userAccount';
    }
}
