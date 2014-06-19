<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use App\Entity\Rate;

class RateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('level0', 'number');
        $builder->add('level1', 'number');
        $builder->add('level2', 'number');
        $builder->add('level3', 'number');
        $builder->add('level4', 'number');
        $builder->add('level5', 'number');
        $builder->add('level6', 'number');
        $builder->add('level7', 'number');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Rate'
        ]);
    }

    public function getName()
    {
        return 'rate';
    }
}
