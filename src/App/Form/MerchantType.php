<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use App\Entity\Merchant;

class MerchantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder->add('expiryDate', 'date', ['required' => false, 'widget' => 'single_text']);
        $builder->add('name');
        $builder->add('alternativeName');
        $builder->add('category');
        $builder->add('network');
        $builder->add('networkMerchantId', null, ['required' => false]);
        $builder->add('logoFile');
        $builder->add('description');
        $builder->add('commission', null, ['precision' => 2]);
        $builder->add('commissionMax', null, ['precision' => 2]);
        $builder->add('commissionType', 'choice', [
            'choices' => [
                Merchant::COMMISSION_TYPE_FIXED => 'Fixed Amount',
                Merchant::COMMISSION_TYPE_PERCENTAGE => 'Percentage Off',
                Merchant::COMMISSION_TYPE_FIXED_VAR => 'Variable Fixed Amount',
                Merchant::COMMISSION_TYPE_PERCENTAGE_VAR => 'Variable Percentage Off',
            ],
        ]);
        $builder->add('topStore', null, ['required' => false]);
        $builder->add('clickoutUrl', null, ['required' => false]);
        $builder->add('noSubid', null, ['required' => false]);
        $builder->add('active', null, ['required' => false]);
        $builder->add('submit', SubmitType::class, [
            'attr' => ['class' => 'btn-primary'],
        ]);
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
