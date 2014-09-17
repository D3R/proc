<?php

namespace D3R\Proc\Console\Command\Config;

use D3R\Proc\Config\Exception as ConfigException;
use D3R\Proc\Console\Command\Command;
use D3R\Proc\Filesystem\File\File;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Console command to show the current config
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package D3R\Proc\Console\Command\Config
 */
class Show extends Command
{
    protected function configure()
    {
        $this
            ->setName('config:show')
            ->setDescription('Show current configuration information')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file      = $this->getConfig()->getFile();

        if (!$file instanceof File) {
            $output->writeLn('No configuration file found');
            return;
        }
        $output->writeLn('Configuration file found at ' . $file->path());
        $output->writeLn(str_repeat('=', 100));
        $output->write($file->content());
        $output->writeLn(str_repeat('=', 100));
    }
}
