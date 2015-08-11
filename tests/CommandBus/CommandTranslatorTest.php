<?php namespace SmoothPhp\SymfonyBridge\Test;

use PHPUnit_Framework_TestCase as TestCase;
use SmoothPhp\SymfonyBridge\CommandBus\CommandTranslator;

/**
 * Class CommandTranslatorTest
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class CommandTranslatorTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_return_the_class_name()
    {
        $translator = new CommandTranslator;

        $this->assertSame(self::class, $translator->toCommandHandler($this));
    }
}