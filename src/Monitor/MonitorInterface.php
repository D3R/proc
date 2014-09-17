<?php

namespace D3R\Proc\Monitor;

/**
 * Base interface for monitor objects
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Monitor
 */
interface MonitorInterface
{
    /**
     * Initialise the loop for this monitor
     *
     * @return void
     * @throws D3R\Proc\Exception
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function loop();
}
