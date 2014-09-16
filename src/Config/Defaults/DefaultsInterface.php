<?php

namespace D3R\Proc\Config\Defaults;

/**
 * DefaultsInterface for supplying configuration defaults
 *
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package D3R\Proc\Config\Defaults
 */
interface DefaultsInterface
{
    /**
     * Get a default value for a key
     *
     * @param string $key
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function get($key);

    /**
     * Get the label for a given key
     *
     * This method should return something sensible if the key does not have an explicit label
     *
     * @param string $key
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function label($key);

    /**
     * Get all default keys
     *
     * @return string[]
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getKeys();

    /**
     * Get a minimum set of required config keys
     *
     * @return array
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getRequiredKeys();
}
