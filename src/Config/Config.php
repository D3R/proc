<?php

namespace D3R\Proc\Config;

use D3R\Proc\Config\Defaults\Defaults;
use D3R\Proc\Config\Defaults\DefaultsInterface;
use D3R\Proc\Filesystem\LocalFilesystem;
use D3R\Proc\Filesystem\File\FileInterface;

/**
 * Simple config object class
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Config
 */
class Config implements ConfigInterface
{
    const BASENAME = 'd3r-proc.ini';

    /**
     * The singleton instance of this class
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected static $singleton = null;

    /**
     * Standard singleton static getter
     *
     * @return static
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public static function singleton()
    {
        if (false == (static::$singleton instanceof static)) {
            $locations = array(
                static::getSystemConfig(),
                static::getUserConfig()
            );

            $config = new Config();
            $config->defaults(new Defaults());
            $config->load($locations);

            static::$singleton = $config;
        }
        return static::$singleton;
    }

    /**
     * Get a system config file object
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public static function getSystemConfig()
    {
        $fs = new LocalFilesystem();
        return $fs->file($fs->etc(), static::BASENAME);
    }

    /**
     * Get a system config file object
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public static function getUserConfig()
    {
        $fs = new LocalFilesystem();
        return $fs->file($fs->home(), static::BASENAME);
    }

    /**
     * The config file that we loaded data from
     *
     * @var D3R\Filesystem\FileInterface
     */
    protected $file;

    /**
     * The resolved config data array
     *
     * @var array
     */
    protected $data = array();

    /**
     * A set of immutable values that can't be changed
     *
     * @var array
     */
    protected $immutable = array();

    /**
     * Defaults object
     *
     * @var D3R\Config\Defaults\DefaultsInterface
     */
    protected $defaults;

    /**
     * Class constructor
     *
     * Protected to comply with the singleton pattern
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function __construct()
    {
        $this->loadImmutables();
    }

    /**
     * Magic clone method
     *
     * Protected to comply with the singleton pattern
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function __clone()
    {
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function load($locations)
    {
        if (!is_array($locations)) {
            $locations = array($locations);
        }

        if (0 == count($locations)) {
            return false;
        }

        foreach ($locations as $location) {
            if (!$location instanceof FileInterface) {
                continue;
            }

            if (!$location->exists() || !$location->read()) {
                continue;
            }

            if (false === ($data = @parse_ini_string($location->content())) || empty($data)) {
                continue;
            }

            $this->file = $location;
            $this->data = $data;
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function defaults(DefaultsInterface $defaults)
    {
        $this->defaults = $defaults;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function label($key)
    {
        if ($this->defaults instanceof DefaultsInterface) {
            return $this->defaults->label($key);
        }

        return $key;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function set($key, $string)
    {
        $this->data[$key] = $string;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function get($key, $default = null)
    {
        if (isset($this->immutable[$key])) {
            if (is_callable($this->immutable[$key])) {
                $this->immutable[$key] = $this->immutable[$key]();
            }
            return $this->immutable[$key];
        }

        if (!isset($this->data[$key])) {
            if (is_null($default)) {
                return $this->getDefault($key);
            }
            return $default;
        }

        return (string) $this->data[$key];
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function bool($key, $default = null)
    {
        $value = $this->get($key, null);
        if (is_null($value)) {
            return $default;
        }

        switch ($value) {
            case "1":
            case "y":
            case "yes":
            case "true":
                return true;
            default:
                return false;
        }
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getArray()
    {
        return $this->data;
    }

    /**
     * Get the default value for a given key
     *
     * @param string $key
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getDefault($key)
    {
        if ($this->defaults instanceof DefaultsInterface) {
            return $this->defaults->get($key);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Load the immutable keys
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function loadImmutables()
    {
        $this->immutable['render.basepath'] = function () {
            $fs = new LocalFilesystem();
            return $fs->join(dirname(dirname(dirname(__FILE__))), 'templates');
        };

        $options = array(
                's' => 'os',
                'm' => 'machine'
            );
        foreach ($options as $option => $label) {
            $this->immutable['uname.' . $label] = function () use ($option) {
                return php_uname($option);
            };
        }

        $hostname = php_uname('n');
        if (strpos($hostname, '.')) {
            list($hostname, $dummy) = explode('.', $hostname, 2);
        }
        $this->immutable['uname.hostname']     = $hostname;

        $this->immutable['backup.bucket']      = 'd3r-backups';
        $this->immutable['backup.path.site']   = 'sites';
        $this->immutable['backup.path.server'] = 'servers';
    }
}
