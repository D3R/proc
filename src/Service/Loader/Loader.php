<?php

namespace D3R\Proc\Service\Loader;

use D3R\Proc\Config\ConfigInterface;
use D3R\Proc\Config\HasConfigTrait;
use D3R\Proc\Exception;
use D3R\Proc\Filesystem\LocalFilesystem;

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
    use HasConfigTrait;

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
     * Scan for service definitions
     *
     * @return void
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function scan()
    {
        $config = $this->getConfig();
        $fs     = new LocalFilesystem();

        $serviceRoot = $config->get('dir.services');
        if (!$fs->exists($serviceRoot)) {
            throw new Exception('Service root does not exist');
        }
    }
}
