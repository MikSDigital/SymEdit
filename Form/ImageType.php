<?php

namespace Isometriks\Bundle\SymEditBundle\Form; 

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class ImageType extends AbstractType
{    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {        
        $resolver->setDefaults(array(
            'require_name' => true, 
            'required' => true,
            'translation_domain' => 'SymEdit', 
            'label' => 'Image',
            'show_image' => true,
        ));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['show_image'] = $options['show_image'];
    }

    public function getParent()
    {
        return 'isometriks_media';
    }
    
    public function getName()
    {
        return 'symedit_image';
    }
}
