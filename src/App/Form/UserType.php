<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use App\Entity\User;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email');
        $builder->add('alias');
        $builder->add('firstName');
        $builder->add('address');
        $builder->add('city');
        $builder->add('state');
        $builder->add('zip');
        $builder->add('referredBy', new UserSelectorType($options['em']), [
            'invalid_message' => 'The referrer email is not found in the user database'
        ]);
        $builder->add('status', 'choice', [
            'choices' => [
                User::STATUS_ACTIVE,
                User::STATUS_INACTIVE,
            ]
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\User',
        ]);

        $resolver->setRequired(['em']);
        $resolver->setAllowedTypes(['em' => 'Doctrine\Common\Persistence\ObjectManager']);
    }

    public function getName()
    {
        return 'user';
    }
}
