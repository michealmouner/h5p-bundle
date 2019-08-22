<?php

namespace Emmedy\H5PBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class EmmedyH5PExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        /** @var $definition \Symfony\Component\DependencyInjection\Definition **/
        $definition = $container->getDefinition("emmedy_h5p.core");

        $definition->setArgument(1, $container->getParameter('kernel.project_dir') . '/' . $config['web_dir'] . '/' . $config["storage_dir"]);
        $definition->setArgument(2, '/');

        $definition = $container->getDefinition("emmedy_h5p.options");
        $definition->setArgument(0, $config);
    }
}
