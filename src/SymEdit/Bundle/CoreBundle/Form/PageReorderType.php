<?php

namespace SymEdit\Bundle\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageReorderType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(!$options['render']){
            $builder
                    ->add('pair', 'collection', array(
                        'type' => 'integer',
                        'property_path' => '[pair]', 
                        'allow_add' => true, 
                    ));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'render' => false, 
        ));
    }

    public function getName()
    {
        return 'isometriks_page_reorder';
    }

}