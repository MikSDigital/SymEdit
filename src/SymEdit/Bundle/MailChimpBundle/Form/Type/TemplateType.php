<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MailChimpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ZfrMailChimp\Client\MailChimpClient;

class TemplateType extends AbstractType
{
    protected $client;

    public function __construct(MailChimpClient $client)
    {
        $this->client = $client;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choices = array();

        try {
            $lists = $this->client->getTemplates();

            foreach ($lists['data'] as $list) {
                $name = $list['name'];
                $choices[$name] = $name;
            }

            $resolver->setDefaults(array(
                'choices' => $choices,
            ));

        } catch (Exception $e) {

            $resolver->setDefaults(array(
                'disabled' => true,
                'help_block' => 'Invalid API Key, cannot choose a list.',
            ));
        }
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'mailchimp_template';
    }
}