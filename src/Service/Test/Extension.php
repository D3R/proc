<?php

namespace D3R\Proc\Service\Test;

/**
 * Test for php extensions
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Service\Test
 */
class Extension implements TestInterface
{
    use TestOptionsTrait;

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function evaluate()
    {
        $name = $this->getOption('name');

        return extension_loaded($name);
    }
}
