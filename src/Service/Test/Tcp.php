<?php

namespace D3R\Proc\Service\Test;

/**
 * Test that a particular tcp port (localhost only atm) is open
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Service\Test
 */
class Tcp implements TestInterface
{
    use TestOptionsTrait;

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function evaluate()
    {
        $port = $this->getOption('port');
        if (false === ($sock = fsockopen('127.0.0.1', $port, $errno, $errstr, 1))) {
            return false;
        }
        fclose($sock);

        return true;
    }
}
