<?php

namespace D3R\Proc\Service\Test\Factory;

use D3R\Proc\Exception;
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
     * Get an instance of a test object from an xml fragment
     *
     * @param \SimpleXMLElement
     * @return D3R\Proc\Service\Test\TestInterface
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function fromXML(\SimpleXMLElement $xml)
    {
        $class   = $this->resolveType((string) $xml['type']);
        $options = array();
        foreach ($xml->attributes() as $key => $value) {
            if ('type' == $key) {
                continue;
            }
            $options[$key] = (string) $value;
        }

        return new $class($options);
    }

    /**
     * Resolve a test class from a given type name
     *
     * @param string $type
     * @return D3R\Proc\Service\Test\TestInterface
     * @throws D3R\Proc\Exception
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function resolveType($type)
    {
        $class = 'D3R\Proc\Service\Test\\' . ucfirst(strtolower($type));
        if (!class_exists($class)) {
            throw new Exception('Unknown test type ' . $type);
        }

        return $class;
    }
}
