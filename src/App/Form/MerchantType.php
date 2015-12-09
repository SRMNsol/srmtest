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
            ->add('network')
            ->add('networkMerchantId', null, ['required' => false])
            ->add('logoFile')
            ->add('skipLogoUpdate', 'checkbox', ['required' => false])
            ->add('name')
            ->add('alternativeName')
            ->add('description')
            ->add('commission', null, ['precision' => 2])
            ->add('commissionMax', null, ['precision' => 2])
            ->add('commissionType', 'choice', [
                'choices' => [
                    Merchant::COMMISSION_TYPE_FIXED => 'Fixed Amount',
                    Merchant::COMMISSION_TYPE_PERCENTAGE => 'Percentage Off',
                    Merchant::COMMISSION_TYPE_FIXED_VAR => 'Variable Fixed Amount',
                    Merchant::COMMISSION_TYPE_PERCENTAGE_VAR => 'Variable Percentage Off',
                ],
            ])
            ->add('topStore', 'checkbox', ['required' => false])
            ->add('clickoutUrl', null, ['required' => false])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Merchant',
        ));
    }

    public function getName()
    {
        return 'merchant';
    }
}
