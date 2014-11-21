<?php

namespace D3R\Proc;

use D3R\Proc\Exception;
use D3R\Proc\Filesystem\LocalFilesystem;
use D3R\Proc\Service\Service;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * A tree implementation to maintain a set of files on disk
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R
 */
class Tree implements TreeInterface
{
    /**
     * Rhe root directory for this tree
     *
     * @var string
     */
    protected $root;

    /**
     * Tree nodes
     *
     * This is an associative array where the keys are paths and the values are
     * the service objects that correspond to the path
     *
     * @var array
     */
    protected $nodes;

    /**
     * Should the tree monitor loop or not?
     *
     * @var bool
     */
    protected $loop;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct($root)
    {
        $this->root  = $root;
        $this->nodes = array();
        $this->loop  = true;
    }

    /**
     * @author  Ronan Chilvers <ronan@d3r.com>
     */
    public function attach(Service $service)
    {
        $path = $service->getPath();
        if (isset($this->nodes[$path])) {
            throw new Exception('Duplicate tree path ' . $path);
        }
        $this->nodes[$service->getPath()] = $service;

        return $this;
    }

    /**
     * @author  Ronan Chilvers <ronan@d3r.com>
     */
    public function monitor(OutputInterface $output, $refreshInterval = 1)
    {
        while ($this->loop) {
            foreach ($this->nodes as $path => $service) {
                if (true == $service->evaluate()) {
                    $output->writeLn('creating node ' . $path);
                    $this->createNode($path);
                } else {
                    $output->writeLn('removing node ' . $path);
                    $this->removeNode($path);
                }
            }
            $output->writeLn('sleeping for ' . $refreshInterval . ' seconds');
            sleep($refreshInterval);
        }

        foreach ($this->nodes as $path => $node) {
            $this->removeNode($path);
        }
    }

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function stop()
    {
        $this->loop = false;
    }

    /**
     * Create a node on disk
     *
     * @param  string $path
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function createNode($path)
    {
        $fs   = new LocalFilesystem();
        $file = $fs->file($this->root, $path);
        if ($file->exists()) {
            return true;
        }

        return $file->touch();
    }

    /**
     * Delete a node from the disk
     *
     * @param  string $path
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function removeNode($path)
    {
        $fs   = new LocalFilesystem();
        $file = $fs->file($this->root, $path);
        if (!$file->exists()) {
            return true;
        }

        return $file->unlink();
    }
}
