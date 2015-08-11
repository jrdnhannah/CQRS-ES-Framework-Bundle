<?php namespace SmoothPhp\SymfonyBridge\Bundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class DiExtension
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DiExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        (new XmlFileLoader($container, new FileLocator(__DIR__ . '/Resources/config')))->load('services.xml');
    }

    /**
     * {@inheritDoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($this->getAlias());
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'smooth_php_framework';
    }
}