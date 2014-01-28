<?php

namespace SymEdit\Bundle\MailChimpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ZfrMailChimp\Client\MailChimpClient;

class ListType extends AbstractType
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
            $lists = $this->client->getLists();

            foreach ($lists['data'] as $list) {
                $name = $list['name'];
                $choices[$name] = $name;
            }

            $resolver->setDefaults(array(
                'choices' => $choices,
            ));

        } catch (\Exception $e) {

            $resolver->setDefaults(array(
                'disabled' => true,
            ));
        }
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'mailchimp_list';
    }
}