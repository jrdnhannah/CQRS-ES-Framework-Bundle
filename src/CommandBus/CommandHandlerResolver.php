<?php namespace SmoothPhp\SymfonyBridge\CommandBus;

use SmoothPhp\CommandBus\Exception\HandlerNotFound;

/**
 * Class CommandHandlerResolver
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class CommandHandlerResolver implements \SmoothPhp\Contracts\CommandBus\CommandHandlerResolver
{
    /** @var callable[] */
    private $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    /**
     * {@inheritDoc}
     */
    public function make($handlerId)
    {
        $id = base64_encode($handlerId);

        if (!isset($this->handlers[$id])) {
            throw new HandlerNotFound($handlerId);
        }

        return $this->handlers[$id];
    }

    /**
     * @param callable $handler
     * @param string   $handles
     */
    public function addCommandHandler(callable $handler, $handles)
    {
        $this->handlers[base64_encode($handles)] = $handler;
    }
}