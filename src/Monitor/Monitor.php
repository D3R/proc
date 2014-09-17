<?php

namespace D3R\Proc\Monitor;

use D3R\Proc\Config\ConfigInterface;
use D3R\Proc\Config\HasConfigTrait;
use D3R\Proc\Container\HasContainerTrait;
use Pimple\Container;

/**
 * Monitor object responsible for collectng and monitoring service definitions
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Monitor;
 */
class Monitor implements MonitorInterface
{
    use HasConfigTrait;
    use HasContainerTrait;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(ConfigInterface $config)
    {
        $this->setConfig($config);
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function loop()
    {
    }
}
