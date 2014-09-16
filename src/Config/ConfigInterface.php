<?php

namespace D3R\Proc\Config;

use D3R\Proc\Filesystem\File\FileInterface; // Not explicit but expected by load()
use D3R\Proc\Config\Defaults\DefaultsInterface;

/**
 * Configuration component interface
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package D3R\Proc\Config
 */
interface ConfigInterface
{
    /**
     * Try to load a valid config file from a given set of locations
     *
     * This method should attempt to load a valid configuration from each of the given locations in turn
     * returning true if it manages to load one and false otherwise. NB: Returning false is not the end of
     * the world - the config object is still usable with its defaults.
     *
     * @param FileInterface[]|FileInterface $location A single instance or array of FileInterface objects
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function load($locations);

    /**
     * Set a schema for the config
     *
     * @param D3R\Config\Defaults\DefaultsInterface
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function defaults(DefaultsInterface $defaults);

    /**
     * Get the label for a given key
     *
     * This method may proxy through to the defaults object if it doesn't have a label stored internally
     * for a given key already.
     *
     * @param string $key
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function label($key);

    /**
     * Set a config variable
     *
     * @param string $key
     * @param string $value
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function set($key, $string);

    /**
     * Get a string value from the config by key
     *
     * @param string $key
     * @param mixed $default
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function get($key, $default = null);

    /**
     * Get a boolean value from the config by key
     *
     * @param string $key
     * @param mixed $default
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function bool($key, $default = null);

    /**
     * Get the whole config array
     *
     * @return array
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getArray();

    /**
     * Get the file that this config was loaded from
     *
     * @return D3R\Filesystem\FileInterface
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getFile();
}
