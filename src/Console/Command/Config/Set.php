<?php

namespace D3R\Proc\Console\Command\Config;

use D3R\Proc\Config\Config;
use D3R\Proc\Config\Defaults\Defaults;
use D3R\Proc\Config\Writer;
use D3R\Proc\Console\Command\Command;
use D3R\Proc\Exception;
use D3R\Proc\Filesystem\File\File;
use D3R\Proc\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Console command for setting up a new configuration file
 *
 * This command assumes at the moment that the config file is an inifile
 *
 * @see       D3R\Config\Inifile
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package D3R\Proc\Console\Command\Config
 */
class Set extends Command
{
    protected function configure()
    {
        $this
            ->setName('config:set')
            ->setDescription('Set a specific config value')
            ->addArgument(
                'key',
                InputArgument::REQUIRED,
                'The config key to set'
            )
            ->addArgument(
                'value',
                InputArgument::REQUIRED,
                'The config value to set'
            )
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper    = $this->getHelper('question');
        $key       = $input->getArgument('key');
        $value     = $input->getArgument('value');

        $config    = $this->getConfig();
        $file      = $config->getFile();

        $output->writeLn('Modifying configuration at ' . $file->path());

        $config->set($key, $value);

        $output->writeLn('Your config now looks like this:');
        $output->writeLn('');
        foreach ($config->getArray() as $key => $value) {
            if ($key != ($label = $config->label($key))) {
                $output->writeLn("; {$label}");
            }
            $output->writeLn("{$key} = {$value}");
        }
        $output->writeLn('');

        if (!$helper->ask($input, $output, new ConfirmationQuestion('Write this config to disk (y/n)? '))) {
            $output->writeLn('K bye!');
            return;
        }

        $writer = new Writer();
        if (!$writer->write($config, $file->truncate())) {
            throw new Exception('Unable to write config file to ' . $file->path());
        }

        $output->writeLn('Configuration written successfully to ' . $file->path());
    }
}
