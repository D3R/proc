<?php

namespace D3R\Proc;

use D3R\Proc\Exception;
use D3R\Proc\Service\Service;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface for Tree objects
 *
 * A tree object implements a tree structure that represents the state of the
 * variosu services attached to it.
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R
 */
interface TreeInterface
{
    /**
     * Attach a service to the tree
     *
     * @param   D3R\Proc\Service\Service $service
     * @return  $this
     * @throws  D3R\Proc\Exception
     * @author  Ronan Chilvers <ronan@d3r.com>
     */
    public function attach(Service $service);

    /**
     * Start monitoring services and maintain the tree stcutre accordingly
     *
     * @param   string $root
     * @param   int $refreshInterval The interval for tree refreshes in seconds
     * @param   Symfony\Component\Console\Output\OutputInterface $output
     * @return  void
     * @author  Ronan Chilvers <ronan@d3r.com>
     */
    public function monitor($root, $refreshInterval = 1, OutputInterface $output);

    /**
     * Stop monitoring the tree
     *
     * @return void
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function stop();
}
