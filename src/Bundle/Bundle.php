<?php namespace SmoothPhp\SymfonyBridge\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class Bundle
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class Bundle extends \Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new Compiler\LoadEventListeners);
    }

    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        return new DiExtension;
    }
}