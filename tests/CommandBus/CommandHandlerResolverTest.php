<?php namespace SmoothPhp\SymfonyBridge\Test;

use Closure;
use ReflectionProperty;
use PHPUnit_Framework_TestCase as TestCase;
use SmoothPhp\CommandBus\Exception\HandlerNotFound;
use SmoothPhp\SymfonyBridge\CommandBus\CommandTranslator;
use SmoothPhp\SymfonyBridge\CommandBus\CommandHandlerResolver;
use SmoothPhp\SymfonyBridge\Test\Stub\CommandBus\CommandStub;

/**
 * Class CommandHandlerResolverTest
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class CommandHandlerResolverTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_return_a_handler()
    {
        $resolver = new CommandHandlerResolver;
        $translator = new CommandTranslator;

        $resolver->addCommandHandler(function () {}, CommandStub::class);

        $this->assertInstanceOf(Closure::class, $resolver->make($translator->toCommandHandler(new CommandStub)));
    }

    /**
     * @test
     */
    public function it_should_only_add_one_handler_per_command()
    {
        $resolver   = new CommandHandlerResolver;
        $translator = new CommandTranslator;
        $refl       = new ReflectionProperty(CommandHandlerResolver::class, 'handlers');
        $refl->setAccessible(true);

        $this->assertSame(0, count($refl->getValue($resolver)));

        $resolver->addCommandHandler(function () { return 'foo';}, $translator->toCommandHandler(new CommandStub));
        $resolver->addCommandHandler(function () { return 'bar';}, $translator->toCommandHandler(new CommandStub));

        $handler = $resolver->make($translator->toCommandHandler(new CommandStub));

        $this->assertSame('bar', call_user_func($handler));
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_if_handler_isnt_resolved()
    {
        $this->setExpectedException(HandlerNotFound::class);

        $resolver = new CommandHandlerResolver;

        $resolver->make('foo.bar');
    }
}