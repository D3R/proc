<?php

namespace D3R\Proc\Console;

use D3R\Proc\Config\HasConfigTrait;
use D3R\Proc\Constants;
use D3R\Proc\Config\ConfigInterface;
use Symfony\Component\Console\Application as BaseApplication;

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
            new Command\Proc\Maintain()
        ));

        return $commands;
    }
}
