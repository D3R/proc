<?php

namespace D3R\Proc\Config\Defaults;

/**
 * Defaults object containing default config values
 *
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package D3R\Proc\Config\Defaults
 */
class Defaults implements DefaultsInterface
{
    /**
     * Array of default values
     *
     * @var array
     */
    protected $defaults = array();

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct()
    {
        $this->initDefaults();
    }

    /**
     * Initialise the defaults array
     *
     * @return void
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function initDefaults()
    {
        $this->defaults = array(
            'dir.root' => array(
                'value'    => '/',
                'label'    => 'The root directory in which the proc filesystem root will be created',
                'required' => true
            ),
            'dir.services' => array(
                'value'    => '/etc/d3r-proc.d',
                'label'    => 'The directory in which member configs are stored',
                'required' => true
            ),
        );
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function get($key)
    {
        if (isset($this->defaults[$key]['value'])) {
            if (is_callable($this->defaults[$key]['value'])) {
                return $this->defaults[$key]['value']();
            }
            return $this->defaults[$key]['value'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function label($key)
    {
        if (isset($this->defaults[$key]['label'])) {
            return $this->defaults[$key]['label'];
        }

        return $key;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getKeys()
    {
        return array_keys($this->defaults);
    }

    /**
     * Get a minimum set of required config keys
     *
     * @return array
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getRequiredKeys()
    {
        $keys   = array();
        foreach ($this->defaults as $key => $data) {
            if (isset($data['required']) && true === $data['required']) {
                $keys[] = $key;
            }
        }

        return $keys;
    }
}
