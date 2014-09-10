<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-02
 */

namespace ZfLocatorGenerator;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface;

/**
 * Class Module
 * @package LocatorGenerator
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ConsoleBannerProviderInterface, ConsoleUsageProviderInterface
{
    const VERSION = '1.0.0';

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Returns a string containing a banner text, that describes the module and/or the application.
     * The banner is shown in the console window, when the user supplies invalid command-line parameters or invokes
     * the application with no parameters.
     *
     * The method is called with active Zend\Console\Adapter\AdapterInterface that can be used to directly access Console and send
     * output.
     *
     * @param AdapterInterface $console
     * @return string|null
     */
    public function getConsoleBanner(AdapterInterface $console)
    {
        return 'Zf Locator Generator - Version ' . self::VERSION;
    }

    /**
     * @param AdapterInterface $console
     * @return array|null|string
     */
    public function getConsoleUsage(AdapterInterface $console)
    {
        return array(
            'locator generate [<locator_name>] [--verbose]'  => 'run generation of locator depending on your configuration',
            'locator list '  => 'list available locator with configuration path'
        );
    }
}
