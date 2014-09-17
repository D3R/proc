<?php

namespace D3R\Proc\Console;

use D3R\Proc\Config\ConfigInterface;
use D3R\Proc\Config\HasConfigTrait;
use D3R\Proc\Constants;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command as ConsoleCommand;

/**
 * Console application
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R
 */
class Application extends BaseApplication
{
    use HasConfigTrait;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(ConfigInterface $config)
    {
        $this->setConfig($config);

        parent::__construct(Constants::NAME, Constants::VERSION);
    }

    /**
     * {@inheritdoc}
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();

        $commands = array_merge($commands, array(
            new Command\Proc\Maintain(),
            new Command\Config\Show(),
            new Command\Config\Setup()
        ));

        return $commands;
    }

    /**
     * {@inheritdoc}
     *
     * Overriden to allow setting in config, log and container objects
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function add(ConsoleCommand $command)
    {
        $command = parent::add($command);
        if ($command instanceof Command\Command) {
            $command->setConfig($this->getConfig());
        }

        return $command;
    }
}
