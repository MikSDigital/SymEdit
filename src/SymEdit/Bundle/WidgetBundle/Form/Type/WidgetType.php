<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SymEdit\Bundle\WidgetBundle\Form\DataTransformer\WidgetAssociationTransformer;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;

class WidgetType extends AbstractType
{
    protected $widgetClass;
    protected $widgetAreaClass;

    public function __construct($widgetClass, $widgetAreaClass)
    {
        $this->widgetClass = $widgetClass;
        $this->widgetAreaClass = $widgetAreaClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new WidgetAssociationTransformer();

        $basic = $builder->create('basic', 'tab', array(
            'label' => 'symedit.form.widget.tab.basic',
            'icon' => 'info-sign',
            'inherit_data' => true,
            'data_class' => $this->widgetClass,
        ));

        $basic
            ->add('title', 'text', array(
                'label' => 'symedit.form.widget.basic.title',
                'required' => false,
            ))
            ->add('name', 'text', array(
                'label' => 'symedit.form.widget.basic.name.label',
                'help_block' => 'symedit.form.widget.basic.name.help',
            ))
            ->add('area', 'entity', array(
                'label' => 'symedit.form.widget.basic.area',
                'property' => 'area',
                'class' => $this->widgetAreaClass,
            ))
            ->add('visibility', 'choice', array(
                'label' => 'symedit.form.widget.basic.visibility.label',
                'choices' => array(
                    WidgetInterface::INCLUDE_ALL => 'symedit.form.widget.basic.visibility.include_all',
                    WidgetInterface::INCLUDE_ONLY => 'symedit.form.widget.basic.visibility.include_only',
                    WidgetInterface::EXCLUDE_ONLY => 'symedit.form.widget.basic.visibility.exclude_only',
                ),
            ))
            ->add(
                $builder->create('assoc', 'textarea', array(
                    'label' => 'symedit.form.widget.basic.associations',
                    'required' => false,
                    'auto_initialize' => false,
                    'attr' => array(
                        'rows' => 8,
                    ),
                ))->addModelTransformer($transformer)
            );

        $builder->add($basic);

        /**
         * Build the config form from the strategy
         */
        $config = $builder->create('options', 'tab', array(
            'label' => 'symedit.form.widget.tab.options',
            'icon' => 'cog',
        ));

        $options['strategy']->buildForm($config);

        /**
         * Add to the final form if config has children
         */
        if ($config->count() > 0) {
            $builder->add($config);
        }

        return $builder->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'strategy',
        ));
    }

    public function getName()
    {
        return 'symedit_widget';
    }
}
