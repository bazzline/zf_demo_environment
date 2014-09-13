<?php
/**
 * @author Net\Bazzline\Component\Locator
 * @since 2014-09-13
 */

namespace Application\Service;

/**
 * Class ExampleLocator
 *
 * @package Application\Service
 */
class ExampleLocator
{
    /**
     * @return \Application\Model\UniqueInvokableInstance
     */
    public function getUniqueInvokableInstance()
    {
        return new \Application\Model\UniqueInvokableInstance();
    }
}