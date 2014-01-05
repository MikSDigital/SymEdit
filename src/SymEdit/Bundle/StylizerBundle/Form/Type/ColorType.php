<?php

namespace SymEdit\Bundle\StylizerBundle\Form\Type; 

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface; 
use Symfony\Component\Form\FormView; 

class ColorType extends AbstractType
{
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['type'] = 'color'; 
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'color';
    }
}