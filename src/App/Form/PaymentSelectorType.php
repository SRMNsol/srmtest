<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PaymentSelectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('payments', 'entity', [
            'class' => 'App\Entity\Payment',
            'multiple' => true,
            'expanded' => true,
            'choices' => $options['payments'],
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Form\Model\PaymentCollection',
            'payments' => [],
        ]);
    }

    public function getName()
    {
        return 'payment_selector';
    }
}
