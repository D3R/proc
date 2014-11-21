<?php

namespace D3R\Proc\Container;

use D3R\Proc\Config\Config;
use D3R\Proc\Monitor\Monitor;
use D3R\Proc\Service\Loader\Loader;
use D3R\Proc\Tree;
use Neutron\SignalHandler\SignalHandler;
use Pimple\Container as Pimple;

/**
 * Container facade that hosts a single static method to obtain a populated container
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc
 */
class Container
{
    /**
     * Container instance
     *
     * @var Pimple/Container
     */
    protected static $singleton;

    /**
     * Get a populated container object
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public static function singleton()
    {
        if (static::$singleton instanceof Pimple\Container) {
            return static::$singleton;
        }

        $config    = Config::singleton();
        $container = new Pimple();

        $container['service.loader'] = function() use ($config) {
            return new Loader($config);
        };

        $container['tree'] = function() use ($config) {
            return new Tree();
        };

        $container['signal.handler'] = function() use ($config) {
            declare(ticks=1);
            return SignalHandler::getInstance();
        };

        static::$singleton = $container;

        return static::$singleton;
    }
}
