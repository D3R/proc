<?php

namespace D3R\Proc\Console\Command\Proc;

use D3R\Proc\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command maintains the proc filesystem
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Console\Command\Proc;
 */
class Maintain extends Command
{
    protected function configure()
    {
        $this
            ->setName('proc:maintain')
            ->setDescription('Run the maintenance loop for the proc filesystem')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
