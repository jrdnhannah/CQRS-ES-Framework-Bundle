<?php namespace SmoothPhp\SymfonyBridge\Bundle\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class LoadCommandHandlers
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class LoadCommandHandlers implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $handlers = $container->findTaggedServiceIds('smooth_php.command_handler');
        $resolver = $container->findDefinition('smooth_php.command_handler_resolver');

        foreach ($handlers as $id => $tag) {
            $resolver->addMethodCall('addCommandHandler', [[new Reference($id), 'handle'], $tag[0]['handles']]);
        }
    }
}