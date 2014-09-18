<?php

namespace D3R\Proc\Service;

use D3R\Proc\Service\Test\TestInterface;

/**
 * Service object implementation
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Service
 */
class Service implements ServiceInterface
{
    /**
     * The service key
     *
     * The service key is an alphanumeric string that is used
     * as the filename for this service's entry in the filesystem
     *
     * @var string
     */
    protected $key;

    /**
     * An array of tests that this service depends on
     *
     * For the key to exist in the filesystem all of these tests
     * must pass
     *
     * @var array[]
     */
    protected $tests;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct($key)
    {
        $this->key   = $key;
        $this->tests = array();
    }

    /**
     * Get the key for this service
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function addTest(TestInterface $test)
    {
        $this->tests[] = $test;

        return $this;
    }
}
