<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-06 
 */

namespace Test\ZfLocatorGenerator;

use PHPUnit_Framework_TestCase;
use Mockery;
use Zend\Stdlib\Parameters;

/**
 * Class ZfLocatorGeneratorTestCase
 * @package Test\ZfLocatorGenerator
 */
class ZfLocatorGeneratorTestCase extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @return Mockery\MockInterface|\Zend\Console\Adapter\AdapterInterface
     */
    protected function getMockOfConsole()
    {
        return Mockery::mock('Zend\Console\Adapter\AdapterInterface');
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\Locator\Command
     */
    protected function getMockOfLocatorGeneratorCommand()
    {
        return Mockery::mock('Net\Bazzline\Component\Locator\Command');
    }

    /**
     * @return Mockery\MockInterface|\Zend\ServiceManager\ServiceLocatorInterface
     */
    protected function getMockOfServiceLocator()
    {
        return Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
    }

    /**
     * @param array $array
     * @return Parameters
     */
    protected function getParameters(array $array = null)
    {
        return new Parameters($array);
    }
}