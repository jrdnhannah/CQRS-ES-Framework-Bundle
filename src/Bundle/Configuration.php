<?php namespace SmoothPhp\SymfonyBridge\Bundle;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class Configuration implements ConfigurationInterface
{
    /** @var string */
    private $alias;

    /**
     * @param string $alias
     */
    public function __construct($alias)
    {
        $this->alias = $alias;
    }
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder;
        $root = $tree->root($this->alias);

        return $tree;
    }
}