<?php

namespace D3R\Proc\Service\Loader;

/**
 * Trait for object that have a service loader dependency
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Service
 */
trait HasLoaderTrait
{
    /**
     * Loader instance
     *
     * @var D3R\Proc\Service\LoaderInterface
     */
    protected $loader;

    /**
     * Set the loader instance for this object
     *
     * @param D3R\Proc\Service\LoaderInterface
     * @return void
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function setLoader(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Get the loader instance for this object
     *
     * @return D3R\Proc\Service\LoaderInterface
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getLoader()
    {
        return $this->loader;
    }
}
