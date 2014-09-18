<?php

namespace D3R\Proc\Monitor;

use D3R\Proc\Config\ConfigInterface;
use D3R\Proc\Config\HasConfigTrait;
use D3R\Proc\Container\HasContainerTrait;
use D3R\Proc\Service\HasLoaderTrait;
use D3R\Proc\Service\LoaderInterface;
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
    use HasLoaderTrait;

    /**
     * Member that controls if the loop() method should continue looping
     *
     * @var boolean
     */
    protected $loop = true;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(ConfigInterface $config, LoaderInterface $loader)
    {
        $this->setConfig($config);
        $this->setLoader($loader);
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function loop()
    {
        // $services = $this->getLoader();
        // while ($this->loop) {
        //     foreach ($services as $service) {
        //         $service->evaluate();
        //     }
        // }
    }
}
