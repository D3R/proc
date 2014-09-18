<?php

namespace D3R\Proc\Service\Test\Factory;

use D3R\Proc\Service\Test\Exception\UnknownTestException;
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
            'extension' => 'D3R\Proc\Service\Test\Extension',
            'tcp'       => 'D3R\Proc\Service\Test\Tcp'
        );

    /**
     * Get an instance of a test object from an xml fragment
     *
     * @param \SimpleXMLElement
     * @return D3R\Proc\Service\Test\TestInterface
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function fromXML(\SimpleXMLElement $xml)
    {
        $type = (string) $xml['type'];
        if (!isset($this->classMap[$type])) {
            throw new UnknownTestException('Unknown test type ' . $type);
        }

        $class = $this->classMap[$type];
        $options = array();
        foreach ($xml->attributes() as $key => $value) {
            if ('type' == $key) {
                continue;
            }
            $options[$key] = (string) $value;
        }

        return new $class($options);
    }
}
