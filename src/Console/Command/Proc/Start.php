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
        $config    = $this->getConfig();
        $container = $this->getContainer();
        $loader    = $container['service.loader'];
        $tree      = $container['tree'];
        $handler   = $container['signal.handler'];

        $output->writeLn('loading services');
        $loader->scan($config->get('dir.services'));

        $output->writeLn('creating tree');
        foreach ($loader->getServices() as $service) {
            $tree->attach($service);
        }
        $output->writeLn('registering monitor with signal handler');
        $handler->register(array(SIGTERM, SIGINT), function() use ($tree) {
            $tree->stop();
        });

        $output->writeLn('starting tree monitor');
        $tree->monitor($output, $config->get('tree.refresh'));

        $output->writeLn('monitoring stopped');
    }
}
