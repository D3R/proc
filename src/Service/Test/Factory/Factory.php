<?php

namespace D3R\Proc\Service\Test\Factory;

use D3R\Proc\Service\Test\Extension;

/**
 * Factory class for tests
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Service\Test
 */
class Factory
{
    /**
     * Map of test classes to XML type names
     *
     * @var array
     */
    protected $classMap = array(
            'extension' => 'D3R\Proc\Service\Test\Extension'
        );

    /**
     * Get an instance of a test object from an xml fragment
     *
     * @param SimpleXMLElement
     * @return D3R\Proc\Service\Test\TestInterface
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function fromXML(SimpleXMLElement $xml)
    {

    }
}
