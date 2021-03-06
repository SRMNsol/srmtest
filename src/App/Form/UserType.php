<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\User;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email');
        $builder->add('alias');
        $builder->add('firstName');
        $builder->add('lastName');
        $builder->add('paymentMethod', 'choice', [
            'choices' => [
                'CHECK' => 'Check',
                'PAYPAL' => 'Paypal',
                'CHARITY' => 'Charity',
            ],
            'empty_value' => 'Choose an option',
            'required' => false,
        ]);
        $builder->add('address');
        $builder->add('city');
        $builder->add('state');
        $builder->add('zip');
        $builder->add('paypalEmail');
        $builder->add('charity', null, [
            'query_builder' => function(EntityRepository $repo) {
                return $repo->createQueryBuilder('c')->orderBy('c.name');
            }
        ]);
        $builder->add('referredBy', new UserSelectorType($options['em']), [
            'invalid_message' => 'The referrer email is not found in the user database'
        ]);
        $builder->add('status', 'choice', [
            'choices' => [
                User::STATUS_ACTIVE => 'Active',
                User::STATUS_INACTIVE => 'Inactive',
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
