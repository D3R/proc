<?php

namespace D3R\Proc\Service;

use D3R\Proc\Constants;
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
     * The namespace for this service
     *
     * Supported namespaces are:
     *   - facility
     *   - service
     *
     * @var string
     */
    protected $namespace = Constants::NAMESPACE_FACILITY;

    /**
     * Array of supported namespaces
     *
     * @var array
     */
    protected $namespaces = [
        Constants::NAMESPACE_FACILITY,
        Constants::NAMESPACE_SERVICE,
    ];

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
    public function __construct($key, $namespace = false)
    {
        $this->key   = $this->normalise($key);
        if (in_array($namespace, $this->namespaces)) {
            $this->namespace = $namespace;
        }
        $this->tests = array();
    }

    /**
     * Get the namespace for this service
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get the path for this service
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getPath()
    {
        return $this->namespace . '/' . $this->key;
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function addTest(TestInterface $test)
    {
        $this->tests[] = $test;

        return $this;
    }

    /**
     * Evaluate all tests and return true if the service is available, false otherwise
     *
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function evaluate()
    {
        foreach ($this->tests as $test) {
            if (!$test->evaluate()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Normalise a key, removing any illegal characters
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function normalise($key)
    {
        return preg_replace('#[^A-z0-9]+#', '_', $key);
    }
}
