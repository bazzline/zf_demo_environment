<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ConsoleBannerProviderInterface, ConsoleUsageProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
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
        return 'Zf Index - Version 1.0.0';
    }
    /**
    * @param AdapterInterface $console
    * @return array|null|string
    */
    public function getConsoleUsage(AdapterInterface $console)
    {
        return array(
            'console index [--verbose]' => 'run index'
        );
    }
}
