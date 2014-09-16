<?php

namespace D3R\Proc\Filesystem\File;

/**
 * FileInterface.php
 *
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package D3R\Proc\Filesystem\File
 */
interface FileInterface
{
    /**
     * Get the path for this file
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function path();

    /**
     * Read this file from disk
     *
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function read();

    /**
     * Truncate a files contents to nothing
     *
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function truncate();

    /**
     * Get / set the contents of this file
     *
     * @param string $content
     * @return $this|string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function content($content = null);

    /**
     * Append content to the file
     *
     * @param string $content
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function append($content);

    /**
     * Add a line to the file
     *
     * @param string $line
     * @return $this
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function line($line);

    /**
     * Does this file exist?
     *
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function exists();

    /**
     * Is this file writable
     *
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function writable();

    /**
     * Is this file readable
     *
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function readable();

    /**
     * Save this file to disk
     *
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function write();

    /**
     * Unlink / delete the file
     *
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function unlink();
}
