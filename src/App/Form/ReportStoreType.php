<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ReportStoreType extends AbstractType
{
   
   
    public function buildForm(FormBuilderInterface $builder, array $options )
    {  
        /*
        $connection = $em->getConnection();
        $RAW_QUERY = 'SELECT id,name FROM Merchant Where active=1';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $stores = $statement->fetchAll();
        echo "<pre>"; print_r($stores); exit;
         * 
         */
        //$builder->add('email', 'dropdown');
        
                
//        $builder
//            ->add('type', 'choice', [
//                'required' => true,
//                'choices' => ['yes' => 'Yes', 'no' => 'No'],
//                'data' => $options['select_option']
//            ]);
        
        $builder->add('startDate', 'date', ['required' => false, 'widget' => 'single_text']);
        $builder->add('endDate', 'date', ['required' => false, 'widget' => 'single_text']);
        $builder->setMethod('GET');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    public function getName()
    {
        return 'user_search';
    }
}
