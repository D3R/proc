<?php

namespace D3R\Proc\Service\Loader;

use D3R\Proc\Config\ConfigInterface;
use D3R\Proc\Config\HasConfigTrait;
use D3R\Proc\Exception;
use D3R\Proc\Filesystem\LocalFilesystem;
use D3R\Proc\Service\Service;
use D3R\Proc\Service\Test\Factory\Factory;

/**
 * Service loader object
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Service
 */
class Loader implements LoaderInterface
{
    /**
     * A set of loaded services
     *
     * @param array
     */
    protected $services;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct()
    {
        $this->services  = array();
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function scan($directory)
    {
        $this->services = array();

        $fs     = new LocalFilesystem();
        if (!$fs->exists($directory)) {
            throw new Exception('Service root does not exist');
        }

        $factory = new Factory();
        foreach (glob($fs->join($directory, '*.xml')) as $file) {
            $xml = simplexml_load_file($file);
            $service = new Service((string) $xml['key'], (string) $xml['namespace']);
            foreach ($xml->test as $testXML) {
                $service->addTest($factory->fromXML($testXML));
            }
            $this->services[] = $service;
        }

        return true;
    }

    /**
     * Get an array of loaded services
     *
     * @return array
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getServices()
    {
        return $this->services;
    }
}
