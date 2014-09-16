<?php

namespace D3R\Proc\Filesystem;

use D3R\Proc\Exception;
use D3R\Proc\Filesystem\File\File;
use D3R\Proc\Filesystem\File\FileInterface;

/**
 * A utility class with some common helper method for dealing with filesystems
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Filesystem
 */
class LocalFilesystem implements FilesystemInterface
{
    /**
     * Get the current user home directory
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function home()
    {
        $env = getenv('HOME');
        if (!empty($env)) {
            return $env;
        }

        if (isset($_SERVER['HOME'])) {
            return $_SERVER['HOME'];
        }

        return dirname(dirname(dirname(__FILE__)));
    }

    /**
     * Get the current filesystem /etc directory
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function etc()
    {
        return '/etc';
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function join()
    {
        $args = func_get_args();
        $args = array_map(function ($value) {
            return rtrim($value, DIRECTORY_SEPARATOR);
        }, $args);

        return implode(DIRECTORY_SEPARATOR, $args);
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function file()
    {
        $filename = call_user_func_array(array($this, 'join'), func_get_args());
        $file     = new File($filename);

        return $file;
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function exists()
    {
        $filename = call_user_func_array(array($this, 'join'), func_get_args());

        return file_exists($filename);
    }

    /**
     * Create a directory for a given path
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function ensureDir()
    {
        $path = call_user_func_array(array($this, 'join'), func_get_args());

        if (is_dir($path)) {
            return true;
        }

        if (false == mkdir($path, 0770, true)) {
            return false;
        }

        return true;
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function copy(FileInterface $source, FileInterface $destination)
    {
        if (!$source->readable()) {
            throw new Exception('Source not readable');
        }
        if ($destination->exists() && !$destination->writable()) {
            throw new Exception('Destination not writable');
        }

        return copy($source->path(), $destination->path());
    }
}
