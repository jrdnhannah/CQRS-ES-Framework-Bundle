<?php namespace SmoothPhp\SymfonyBridge\Test\Bundle\Compiler;

use ReflectionProperty;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\DependencyInjection\Definition;
use SmoothPhp\EventDispatcher\ProjectEnabledDispatcher;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SmoothPhp\SymfonyBridge\Bundle\Compiler\LoadEventListeners;
use SmoothPhp\SymfonyBridge\Test\Stub\EventDispatcher\ListenerStub;

/**
 * Class LoadEventListenersTest
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class LoadEventListenersTest extends TestCase
{
    /** @var ContainerBuilder */
    private $containerBuilder;

    protected function setUp()
    {
        $this->containerBuilder = new ContainerBuilder;
        $this->containerBuilder->setDefinition(
            'smooth_php.event_dispatcher',
            new Definition(ProjectEnabledDispatcher::class)
        );
    }

    /**
     * @test
     */
    public function it_should_add_handlers_to_the_resolver_store()
    {
        $pass = new LoadEventListeners;

        $listener = new Definition(ListenerStub::class);
        $listener->addTag('smooth_php.event_listener', ['method' => 'onEventDispatched', 'event' => 'foo.bar']);

        $this->containerBuilder->setDefinition('foo.bar', $listener);

        $pass->process($this->containerBuilder);

        $resolver = $this->containerBuilder->get('smooth_php.event_dispatcher');

        $refl = new ReflectionProperty(ProjectEnabledDispatcher::class, 'listeners');
        $refl->setAccessible(true);

        $this->assertSame(1, count($refl->getValue($resolver)));
    }
}