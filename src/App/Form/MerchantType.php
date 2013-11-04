<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use App\Popshops\Merchant;

class MerchantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea', [
                'required' => false,
            ])
            ->add('commission', 'number', [
                'precision' => 2,
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('commissionMax', 'number', [
                'label' => 'Comm. (max)',
                'precision' => 2,
                'constraints' => [new Assert\NotBlank()],
            ])
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
            'data_class' => 'App\Popshops\Merchant',
        ));
    }

    public function getName()
    {
        return 'merchant';
    }
}
