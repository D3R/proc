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
     * @return void
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function scan();
}
