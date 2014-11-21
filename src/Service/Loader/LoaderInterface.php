<?php

namespace D3R\Proc\Service\Loader;

/**
 * Base interface for service loaders
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Service
 */
interface LoaderInterface
{
    /**
     * Scan for service definitions
     *
     * @param  string $directory
     * @return bool
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function scan($directory);

    /**
     * Get an array of loaded services
     *
     * @return array
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getServices();
}
