<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class IsometriksSymEditExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $configFiles = array(
            'services', 'user', 'widget', 'routing',
            'form', 'event', 'twig', 'util', 'profiler',
            'orm', 'menu',
        );

        foreach($configFiles as $file){
            $loader->load($file.'.xml');
        }

        $this->loadFragment($config['fragment'], $container);

        /**
         * Add Classes to Compile
         */
        $this->addClassesToCompile(array(
            // services.xml
            'Isometriks\\Bundle\\SymEditBundle\\Finder\\ResourceFinder',

            // event.xml
            'Isometriks\\Bundle\\SymEditBundle\\EventListener\\ControllerListener',

            // twig.xml
            'Isometriks\\Bundle\\SymEditBundle\\Twig\\Extension\\SymEditExtension',
        ));

        $container->setParameter('isometriks_symedit.extensions.routes', $config['extensions']);

        /**
         * Set the Admin Directory
         */
        $container->setParameter('isometriks_symedit.admin_dir', $config['admin_dir']);
    }

    private function loadFragment($config, ContainerBuilder $container)
    {
        $container->setParameter('isometriks_symedit.fragment.strategy', $config['strategy']);
    }

    public function getAlias()
    {
        return 'isometriks_symedit';
    }
}
