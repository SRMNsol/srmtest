<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use App\Entity\Merchant;

class MerchantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea', ['required' => false])
            ->add('commission', 'number', ['precision' => 2])
            ->add('commissionMax', 'number', ['precision' => 2])
            ->add('commissionType', 'choice', [
                'choices' => [
                    Merchant::COMMISSION_TYPE_FIXED => 'Fixed Amount',
                    Merchant::COMMISSION_TYPE_PERCENTAGE => 'Percentage Off',
                    Merchant::COMMISSION_TYPE_FIXED_VAR => 'Variable Fixed Amount',
                    Merchant::COMMISSION_TYPE_PERCENTAGE_VAR => 'Variable Percentage Off',
                ],
                'constraints' => [new Assert\Choice([
                    Merchant::COMMISSION_TYPE_FIXED,
                    Merchant::COMMISSION_TYPE_PERCENTAGE,
                    Merchant::COMMISSION_TYPE_FIXED_VAR,
                    Merchant::COMMISSION_TYPE_PERCENTAGE_VAR,
                ])],
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Merchant',
            'validation_groups' => ['App\Entity\Merchant', 'determineValidationGroups'],
        ));
    }

    public function getName()
    {
        return 'merchant';
    }
}
