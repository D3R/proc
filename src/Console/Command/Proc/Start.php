<?php

namespace D3R\Proc\Console\Command\Proc;

use D3R\Proc\Console\Command\Command;
use D3R\Proc\Monitor\Monitor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command monitors the proc filesystem
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Console\Command\Proc;
 */
class Start extends Command
{
    protected function configure()
    {
        $this
            ->setName('proc:start')
            ->setDescription('Run the monitor loop for the proc filesystem')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $loader = $container['service.loader'];
        $loader->scan();
        // @TODO Remove var_dump
        // var_dump($loader); exit();

        $output->writeLn('Initialising monitor');
        // $monitor = $container['monitor'];
        // $monitor->loop();

        $output->writeLn('Monitor exiting');
    }
}
