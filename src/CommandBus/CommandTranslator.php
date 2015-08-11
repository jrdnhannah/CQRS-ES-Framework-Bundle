<?php namespace SmoothPhp\SymfonyBridge\CommandBus;

/**
 * Class CommandTranslator
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class CommandTranslator implements \SmoothPhp\Contracts\CommandBus\CommandTranslator
{
    /**
     * {@inheritDoc}
     */
    public function toCommandHandler($command)
    {
        return get_class($command);
    }
}