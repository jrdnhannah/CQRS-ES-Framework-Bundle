<?php namespace SmoothPhp\SymfonyBridge\Bundle\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class LoadEventListeners
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class LoadEventListeners implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $listeners = $container->findTaggedServiceIds('smooth_php.event_listener');
        $dispatcher = $container->findDefinition('smooth_php.event_dispatcher');

        foreach ($listeners as $id => $tags) {
            foreach ($tags as $tag) {
                $dispatcher->addMethodCall('addListener', [
                    $tag['event'],
                    [new Reference($id), $tag['method']]
                ]);
            }
        }
    }
}