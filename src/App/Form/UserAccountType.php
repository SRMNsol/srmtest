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
        $builder->add('user', new UserType());
        $builder->add('referrerEmail', 'email', ['required' => false]);
        $builder->add('editPassword', 'checkbox', ['required' => false]);
        $builder->add('newPassword', 'repeated', [
            'type' => 'password',
            'invalid_message' => 'The password fields must match.',
            'required' => false,
            'first_options'  => ['label' => 'New Password'],
            'second_options' => ['label' => 'Repeat'],
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Form\Model\UserAccount',
        ]);
    }

    public function getName()
    {
        return 'userAccount';
    }
}
