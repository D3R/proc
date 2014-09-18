<?php

namespace D3R\Proc\Service\Test;

/**
 * Base interface for all service tests
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Service\Test
 */
interface TestInterface
{
    /**
     * This method reveals if the test passes or not
     *
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function evaluate();
}
