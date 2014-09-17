<?php

namespace D3R\Proc\Console\Command\Config;

use D3R\Proc\Config\Config;
use D3R\Proc\Config\Defaults\Defaults;
use D3R\Proc\Config\Writer;
use D3R\Proc\Console\Command\Command;
use D3R\Proc\Exception;
use D3R\Proc\Filesystem\LocalFilesystem;
use D3R\Proc\Filesystem\File\File;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

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
class Setup extends Command
{
    protected function configure()
    {
        $this
            ->setName('config:setup')
            ->setDescription('Setup d3r-tools, generating a config file')
            ->addOption(
                'system',
                null,
                InputOption::VALUE_NONE,
                'Create a system config file not a user config'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper    = $this->getHelper('question');
        $system    = $input->getOption('system');

        $fs = new LocalFilesystem();
        if (true === $system) {
            $file = $fs->file($fs->etc(), Config::BASENAME);
        } else {
            $file = $fs->file($fs->home(), Config::BASENAME);
        }

        $config = $this->getConfig();
        if ($file->exists()) {
            $output->writeLn('A config file already exists at ' . $file->path());
            if (!$helper->ask($input, $output, new ConfirmationQuestion('Do you want to continue (y/n)? '))) {
                $output->writeLn('Ok bye!');

                return;
            }
            $output->writeLn('Righto - carrying on');
            $config->load($file);
        }

        $output->writeLn('Creating configuration at ' . $file->path());

        $defaults    = new Defaults();
        $config->defaults($defaults);

        $defaultKeys = $defaults->getRequiredKeys();
        foreach ($defaultKeys as $key) {
            $default = $config->get($key);
            $value = $helper->ask(
                $input,
                $output,
                new Question("{$key} : " . $config->label($key) . " [{$default}]: ", $default)
            );
            $config->set($key, $value);
        }

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
