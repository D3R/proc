<?php

namespace D3R\Proc\Service;

use D3R\Proc\Service\Test\TestInterface;

/**
 * Interface for service objects
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Service
 */
interface ServiceInterface
{
    /**
     * Add a test to this service
     *
     * @param D3R\Proc\Service\Test\TestInterface
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function addTest(TestInterface $test);

    /**
     * Get the path for this service
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getPath();

    /**
     * Evaluate all tests and return true if the service is available, false otherwise
     *
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function evaluate();
}
