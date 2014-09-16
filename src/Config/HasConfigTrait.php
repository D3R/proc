<?php

namespace D3R\Proc\Config;

use D3R\Proc\Config\ConfigInterface;

/**
 * Config dependency trait
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Dependencies
 */
trait HasConfigTrait
{
    /**
     * Config instance
     *
     * @var D3R\Proc\Config\ConfigInterface
     */
    private $config;

    /**
     * Set the current config object
     *
     * @param  D3R\Proc\Config\ConfigInterface $config
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get the current config object
     *
     * @return D3R\Proc\Config\ConfigInterface
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getConfig()
    {
        return $this->config;
    }
}
