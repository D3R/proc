<?php

namespace D3R\Proc\Config;

use D3R\Proc\Config\ConfigInterface;
use D3R\Proc\Filesystem\File\FileInterface;

/**
 * Config file writer
 *
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package D3R\Proc\Config
 */
interface WriterInterface
{
    /**
     * Write a configuration object out to a file
     *
     * @param  ConfigInterface $config
     * @param  FileInterface $file
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function write(ConfigInterface $config, FileInterface $file);
}
