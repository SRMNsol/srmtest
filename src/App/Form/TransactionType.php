<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\Transaction;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('merchant', null, [
            'group_by' => 'network',
            'property' => 'network_merchant_name',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('m')
                    ->orderBy('m.name', 'ASC');
            },
            'required' => true,
            'empty_value' => 'Choose merchant',
        ]);
        $builder->add('orderNumber');
        $builder->add('registeredAt', 'date', ['widget' => 'single_text']);
        $builder->add('total');
        $builder->add('commission');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Transaction',
        ]);
    }

    public function getName()
    {
        return 'transaction';
    }
}
