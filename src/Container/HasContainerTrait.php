<?php

namespace D3R\Proc\Container;

use Pimple\Container;

/**
 * Dependency methods for a container object
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Container
 */
trait HasContainerTrait
{
    /**
     * Container object
     *
     * @var Pimple\Container
     */
    private $container;

    /**
     * Set the current container object
     *
     * @param  Pimple\Container $container
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get the container instance
     *
     * @var Pimple\Container
     */
    protected function getContainer()
    {
        return $this->container;
    }
}
