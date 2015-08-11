<?php namespace SmoothPhp\SymfonyBridge\Test\Bundle\Compiler;

use ReflectionProperty;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SmoothPhp\SymfonyBridge\Test\Stub\CommandBus\CommandStub;
use SmoothPhp\SymfonyBridge\Test\Stub\CommandBus\CommandStub2;
use SmoothPhp\SymfonyBridge\CommandBus\CommandHandlerResolver;
use SmoothPhp\SymfonyBridge\Bundle\Compiler\LoadCommandHandlers;
use SmoothPhp\SymfonyBridge\Test\Stub\CommandBus\CommandHandlerStub;

/**
 * Class LoadCommandHandlersTest
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class LoadCommandHandlersTest extends TestCase
{
    /** @var ContainerBuilder */
    private $containerBuilder;

    protected function setUp()
    {
        $this->containerBuilder = new ContainerBuilder;
        $this->containerBuilder->setDefinition(
            'smooth_php.command_handler_resolver',
            new Definition(CommandHandlerResolver::class)
        );
    }

    /**
     * @test
     */
    public function it_should_add_handlers_to_the_resolver_store()
    {
        $pass = new LoadCommandHandlers;

        $handler = new Definition(CommandHandlerStub::class);
        $handler->addTag('smooth_php.command_handler', ['handles' => CommandStub::class]);

        $this->containerBuilder->setDefinition('foo.bar', $handler);

        $pass->process($this->containerBuilder);

        $resolver = $this->containerBuilder->get('smooth_php.command_handler_resolver');

        $refl = new ReflectionProperty(CommandHandlerResolver::class, 'handlers');
        $refl->setAccessible(true);

        $this->assertSame(1, count($refl->getValue($resolver)));
    }

    /**
     * @test
     */
    public function it_should_ignore_additional_tags()
    {
        $pass = new LoadCommandHandlers;

        $handler = new Definition(CommandHandlerStub::class);
        $handler->addTag('smooth_php.command_handler', ['handles' => CommandStub::class]);
        $handler->addTag('smooth_php.command_handler', ['handles' => CommandStub2::class]);

        $this->containerBuilder->setDefinition('foo.bar', $handler);

        $pass->process($this->containerBuilder);

        $resolver = $this->containerBuilder->get('smooth_php.command_handler_resolver');

        $refl = new ReflectionProperty(CommandHandlerResolver::class, 'handlers');
        $refl->setAccessible(true);

        $this->assertSame(1, count($refl->getValue($resolver)));
    }
}