<?php

namespace D3R\Proc\Filesystem\File;

/**
 * A simple abstraction of a file object with common helper methods
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package D3R\Proc\Filesystem\File
 */
class File implements FileInterface
{
    /**
     * Full path for this file
     *
     * @var string
     */
    protected $path;

    /**
     * Contents of the file
     *
     * @var string
     */
    protected $content;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct($path, $content = false)
    {
        $this->path = $path;
        $this->content = $content;
    }

    /**
     * Is this file a directory?
     *
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function isDir()
    {
        return is_dir($this->path);
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Get the directory name for this file
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function dirname()
    {
        return dirname($this->path);
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function read()
    {
        clearstatcache();
        if (!$this->content = @file_get_contents($this->path)) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function truncate()
    {
        $this->content = '';

        return $this;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function content($content = null)
    {
        if (is_null($content)) {
            return $this->content;
        }
        $this->content = $content;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function append($content)
    {
        if (!is_string($this->content)) {
            $this->content = '';
        }
        $this->content .= trim($content);

        return $this;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function line($line)
    {
        if (is_string($this->content) && 0 < strlen($this->content) && "\n" != substr($this->content, -1)) {
            $this->content .= "\n";
        }
        $this->content .= trim($line) . "\n";

        return $this;
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function exists()
    {
        clearstatcache();
        return file_exists($this->path);
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function writable()
    {
        clearstatcache();
        return is_writable($this->path);
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function readable()
    {
        clearstatcache();
        return is_readable($this->path);
    }

    /**
     * Touch a file on disk, creating it if it doesn't exist
     *
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function touch()
    {
        return touch($this->path);
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function write()
    {
        clearstatcache();
        if (!@file_put_contents($this->path, $this->content)) {
            return false;
        }

        return true;
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function unlink()
    {
        clearstatcache();
        if ($this->isDir()) {
            return rmdir($this->path);
        }
        return unlink($this->path);
    }

    /**
     * Magic toString - returns the file content
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __toString()
    {
        return $this->content;
    }
}
