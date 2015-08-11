<?php namespace SmoothPhp\SymfonyBridge\Bundle;

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
    public function getContainerExtension()
    {
        return new DiExtension;
    }
}