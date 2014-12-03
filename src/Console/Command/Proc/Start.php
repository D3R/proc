<?php

namespace D3R\Proc\Console\Command\Proc;

use D3R\Proc\Console\Command\Command;
use D3R\Proc\Monitor\Monitor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
            ->addOption(
                'root',
                null,
                InputOption::VALUE_REQUIRED,
                'Set the root directory for the proc filesystem'
            )
            ->addOption(
                'services',
                null,
                InputOption::VALUE_REQUIRED,
                'The directory to load service definitions from'
            )
            ->addOption(
                'interval',
                null,
                InputOption::VALUE_REQUIRED,
                'The refresh interval for the proc tree in seconds'
            )
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config    = $this->getConfig();
        $container = $this->getContainer();
        $loader    = $container['service.loader'];
        $tree      = $container['tree'];
        $handler   = $container['signal.handler'];

        $root      = $input->getOption('root') ? $input->getOption('root') : $config->get('dir.root') ;
        $services  = $input->getOption('services') ? $input->getOption('services') : $config->get('dir.services') ;
        $interval  = $input->getOption('interval') ? $input->getOption('interval') : $config->get('tree.refresh') ;

        $output->writeLn('<info>initialising</info>');
        $output->writeLn('<comment>loading services</comment>');
        $loader->scan($services);

        $output->writeLn('<comment>creating tree</comment>');
        foreach ($loader->getServices() as $service) {
            $tree->attach($service);
        }
        $output->writeLn('<comment>registering monitor with signal handler</comment>');
        $handler->register(array(SIGTERM, SIGINT), function() use ($tree) {
            $tree->stop();
        });

        $output->writeLn('<info>starting tree monitor</info>');
        $tree->monitor($root, $interval, $output);

        $output->writeLn('<info>monitoring stopped</info>');
    }
}
