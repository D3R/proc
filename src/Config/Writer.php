<?php

namespace D3R\Proc\Config;

use D3R\Proc\Config\ConfigInterface;
use D3R\Proc\Config\WriterInterface;
use D3R\Proc\Filesystem\File\FileInterface;

/**
 * A config writer that outputs ini files
 *
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package D3R\Proc\Config
 */
class Writer implements WriterInterface
{
    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function write(ConfigInterface $config, FileInterface $file)
    {
        $array = $config->getArray();

        $file->line('; Config file generated on ' . date('Y-m-d @ H:i:s'));
        $file->line(';');
        foreach ($array as $key => $value) {
            if ($key != ($label = $config->label($key))) {
                $file->line('; ' . $config->label($key));
            }
            $file->line("{$key} = {$value}");
        }

        if (false === $file->write()) {
            return false;
        }

        return true;
    }
}
