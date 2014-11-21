<?php

namespace D3R\Proc\Service\Test;

use D3R\Proc\Filesystem\LocalFilesystem;

/**
 * Test that a given file path exists
 *
 * @author    Ronan Chilvers <ronan@d3r.com>
 * @copyright 2014 D3R Ltd
 * @license   http://d3r.com/license D3R Software Licence
 * @package   D3R\Proc\Service\Test
 */
class File implements TestInterface
{
    use TestOptionsTrait;

    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function evaluate()
    {
        $path = $this->getOption('path');
        $fs   = new LocalFilesystem();

        return $fs->exists($path);
    }
}
