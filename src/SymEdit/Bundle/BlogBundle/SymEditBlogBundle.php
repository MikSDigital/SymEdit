<?php

namespace SymEdit\Bundle\BlogBundle;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\BlogBundle\DependencyInjection\SymEditBlogExtension;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\DoctrineMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditBlogBundle extends Bundle
{
    public static function getSupportedDrivers()
    {
        return array(
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        );
    }

    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'SymEdit\Bundle\BlogBundle\Model\PostInterface'       => 'symedit.model.post.class',
            'SymEdit\Bundle\BlogBundle\Model\CategoryInterface'   => 'symedit.model.category.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('symedit_blog', $interfaces));

        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'SymEdit\Bundle\BlogBundle\Model',
        ));
    }

    public function getContainerExtension()
    {
        return new SymEditBlogExtension();
    }
}