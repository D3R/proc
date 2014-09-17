<?php

namespace D3R\Proc\Console\Command;

use D3R\Proc\Config\HasConfigTrait;
use D3R\Proc\Container\HasContainerTrait;
use Symfony\Component\Console\Command\Command as BaseCommand;

/**
 * Base Command class
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Console\Command
 */
class Command extends BaseCommand
{
    use HasConfigTrait;
    use HasContainerTrait;
}
