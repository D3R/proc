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
    public function __construct()
    {
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
    public function monitor($root, $refreshInterval = 1, OutputInterface $output)
    {
        while ($this->loop) {
            foreach ($this->nodes as $path => $service) {
                if (true == $service->evaluate()) {
                    $output->writeLn('<comment>creating node ' . $path . '</comment>');
                    $this->createNode($root, $path);
                } else {
                    $output->writeLn('<comment>removing node ' . $path . '</comment>');
                    $this->removeNode($root, $path);
                }
            }
            $output->writeLn('<comment>sleeping for ' . $refreshInterval . ' seconds</comment>');
            sleep($refreshInterval);
        }

        $namespaces = [];
        foreach ($this->nodes as $path => $node) {
            $namespaces[$node->getNamespace()] = $node->getNamespace();
            $this->removeNode($root, $path);
        }
        foreach ($namespaces as $namespace) {
            $this->removeNode($root, $namespace);
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
    protected function createNode($root, $path)
    {
        $fs   = new LocalFilesystem();
        $file = $fs->file($root, $path);
        if (false == $fs->ensureDir($file->dirname())) {
            throw new Exception(
                'Unable to ensure directory ' .
                $file->dirname() .
                ' exists'
            );
        }
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
    protected function removeNode($root, $path)
    {
        $fs   = new LocalFilesystem();
        $file = $fs->file($root, $path);
        if (!$file->exists()) {
            return true;
        }

        return $file->unlink();
    }
}
