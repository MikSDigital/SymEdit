<?php

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\CoreBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;

class AddThisStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        return $this->render('@SymEdit/Widget/addthis.html.twig', array(
            'include_script' => $widget->getOption('include_script'),
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('include_script', 'checkbox', array(
                'required' => false,
                'label' => 'Include Javascript File?',
                'help_block' => 'Try not to include the Javascript file twice on any page.',
            ));
    }

    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOptions(array(
            'include_script' => true,
        ));
    }

    public function getName()
    {
        return 'addthis';
    }

    public function getDescription()
    {
        return 'AddThis Social Sharing';
    }
}
