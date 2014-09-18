<?php

namespace D3R\Proc\Service\Test;

/**
 * Trait to manage options on test objects
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Service\Test
 */
class TestOptionsTrait
{
    /**
     * The options array
     *
     * @var array
     */
    private $options;

    /**
     * Class constructor
     *
     * @param array $options A key/value set of options for this test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Get an option by key
     *
     * @param string $key
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getOption($key)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }

        return null;
    }
}
