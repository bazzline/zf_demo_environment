<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-06 
 */

namespace Test\ZfLocatorGenerator;

use Zend\Console\ColorInterface;
use ZfLocatorGenerator\Controller\Console\IndexController;
use Zend\Console\Request;
use Zend\Console\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

/**
 * Class IndexControllerTest
 * @package Test\ZfLocatorGenerator
 */
class IndexControllerTest extends ZfLocatorGeneratorTestCase
{
    /**
     * @var IndexController
     */
    private $controller;

    /**
     * @var \Mockery\MockInterface|\Zend\Console\Adapter\AdapterInterface
     */
    private $console;

    /**
     * @var MvcEvent
     */
    private $event;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var RouteMatch
     */
    private $routeMatch;

    /**
     * @var \Mockery\MockInterface|\Zend\ServiceManager\ServiceLocatorInterface
     */
    private $serviceLocator;

    protected function setUp()
    {
        $this->console = $this->getMockOfConsole();
        $this->controller = new IndexController();
        $this->event = new MvcEvent();
        $this->request = new Request();
        $this->response = new Response();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->serviceLocator = $this->getMockOfServiceLocator();

        $this->controller->setServiceLocator($this->serviceLocator);
        $this->controller->setEvent($this->event);

        $this->event->setRequest($this->request);
        $this->event->setResponse($this->response);
        $this->event->setRouteMatch($this->routeMatch);

        $this->serviceLocator->shouldReceive('get')
            ->with('console')
            ->andReturn($this->console);
    }

    public function testGenerateActionWithInvalidConfiguration()
    {
        $configuration = array();
        $command = $this->getMockOfLocatorGeneratorCommand();
        $console = $this->console;
        $serviceLocator = $this->serviceLocator;

        $console->shouldReceive('setColor');
        $console->shouldReceive('writeLine')
            ->with('')
            ->times(3);
        $console->shouldReceive('writeLine')
            ->with('caught exception RuntimeException')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('----------------')
            ->twice();
        $console->shouldReceive('writeLine')
            ->with('with message: ')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('expected configuration key "zf_locator_generator" not found')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('and trace: ');
        $console->shouldReceive('writeLine')
            ->with('/^#0/');    //mockery IS awesome: https://github.com/padraic/mockery/blob/master/docs/07-ARGUMENT-VALIDATION.md


        $serviceLocator->shouldReceive('get')
            ->once()
            ->with('Config')
            ->andReturn($configuration);

        $serviceLocator->shouldReceive('get')
            ->with('LocatorGeneratorCommand')
            ->once()
            ->andReturn($command);

        $this->routeMatch->setParam('action', 'generate');

        $this->controller->dispatch($this->request);
    }

    public function testGenerateActionWithEmptyConfiguration()
    {
        $configuration = array(
            'zf_locator_generator' => array(
                'name_to_configuration_path' => array()
            )
        );
        $command = $this->getMockOfLocatorGeneratorCommand();
        $serviceLocator = $this->serviceLocator;

        $serviceLocator->shouldReceive('get')
            ->once()
            ->with('Config')
            ->andReturn($configuration);

        $serviceLocator->shouldReceive('get')
            ->with('LocatorGeneratorCommand')
            ->once()
            ->andReturn($command);

        $this->routeMatch->setParam('action', 'generate');

        $this->controller->dispatch($this->request);
    }

    public function testGenerateActionWithFilledConfigurationAndNoLocatorName()
    {
        $configuration = array(
            'zf_locator_generator' => array(
                'name_to_configuration_path' => array(
                    'locator_one' => __FILE__,
                    'locator_two' => __FILE__
                )
            )
        );
        $command = $this->getMockOfLocatorGeneratorCommand();
        $console = $this->console;
        $serviceLocator = $this->serviceLocator;

        $console->shouldReceive('write')
            ->with('.')
            ->twice();

        $command->shouldReceive('setArguments')
            ->withAnyArgs()
            ->twice();
        $command->shouldReceive('execute')
            ->twice();

        $serviceLocator->shouldReceive('get')
            ->once()
            ->with('Config')
            ->andReturn($configuration);

        $serviceLocator->shouldReceive('get')
            ->with('LocatorGeneratorCommand')
            ->once()
            ->andReturn($command);

        $this->routeMatch->setParam('action', 'generate');

        $this->controller->dispatch($this->request);
    }

    public function testGenerateActionWithFilledConfigurationInvalidLocatorName()
    {
        $configuration = array(
            'zf_locator_generator' => array(
                'name_to_configuration_path' => array(
                    'locator_one' => __FILE__
                )
            )
        );
        $command = $this->getMockOfLocatorGeneratorCommand();
        $console = $this->console;
        $serviceLocator = $this->serviceLocator;

        $console->shouldReceive('setColor');
        $console->shouldReceive('writeLine')
            ->with('')
            ->times(3);
        $console->shouldReceive('writeLine')
            ->with('caught exception InvalidArgumentException')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('----------------')
            ->twice();
        $console->shouldReceive('writeLine')
            ->with('with message: ')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('invalid locator name provided')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('and trace: ');
        $console->shouldReceive('writeLine')
            ->with('/^#0/');

        $serviceLocator->shouldReceive('get')
            ->once()
            ->with('Config')
            ->andReturn($configuration);

        $serviceLocator->shouldReceive('get')
            ->with('LocatorGeneratorCommand')
            ->once()
            ->andReturn($command);

        $this->routeMatch->setParam('action', 'generate');
        $this->request->setParams(
            $this->getParameters(
                array(
                    'locator_name' => 'valid_locator'
                )
            )
        );

        $this->controller->dispatch($this->request);
    }

    public function testGenerateActionWithFilledConfigurationValidLocatorName()
    {
        $configuration = array(
            'zf_locator_generator' => array(
                'name_to_configuration_path' => array(
                    'valid_locator' => __FILE__
                )
            )
        );
        $command = $this->getMockOfLocatorGeneratorCommand();
        $console = $this->console;
        $serviceLocator = $this->serviceLocator;

        $command->shouldReceive('setArguments')
            ->withAnyArgs()
            ->once();
        $command->shouldReceive('execute')
            ->once();

        $console->shouldReceive('write')
            ->with('.')
            ->once();

        $serviceLocator->shouldReceive('get')
            ->once()
            ->with('Config')
            ->andReturn($configuration);

        $serviceLocator->shouldReceive('get')
            ->with('LocatorGeneratorCommand')
            ->once()
            ->andReturn($command);

        $this->routeMatch->setParam('action', 'generate');
        $this->request->setParams(
            $this->getParameters(
                array(
                    'locator_name' => 'valid_locator'
                )
            )
        );

        $this->controller->dispatch($this->request);
    }

    public function testGenerateActionWithFilledConfigurationValidLocatorWithVerbose()
    {
        $configuration = array(
            'zf_locator_generator' => array(
                'name_to_configuration_path' => array(
                    'valid_locator' => __FILE__
                )
            )
        );
        $command = $this->getMockOfLocatorGeneratorCommand();
        $console = $this->console;
        $serviceLocator = $this->serviceLocator;

        $command->shouldReceive('setArguments')
            ->withAnyArgs()
            ->once();
        $command->shouldReceive('execute')
            ->once();

        $console->shouldReceive('writeLine')
            ->with('generating "valid_locator" by using configuration file "' . __FILE__ . '"')
            ->once();

        $serviceLocator->shouldReceive('get')
            ->once()
            ->with('Config')
            ->andReturn($configuration);

        $serviceLocator->shouldReceive('get')
            ->with('LocatorGeneratorCommand')
            ->once()
            ->andReturn($command);

        $this->routeMatch->setParam('action', 'generate');
        $this->request->setParams(
            $this->getParameters(
                array(
                    'locator_name' => 'valid_locator',
                    'verbose' => true
                )
            )
        );

        $this->controller->dispatch($this->request);
    }

    public function testListActionWithInvalidConfiguration()
    {
        $configuration = array();
        $console = $this->console;
        $serviceLocator = $this->serviceLocator;

        $console->shouldReceive('setColor');
        $console->shouldReceive('writeLine')
            ->with('')
            ->times(3);
        $console->shouldReceive('writeLine')
            ->with('caught exception RuntimeException')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('----------------')
            ->twice();
        $console->shouldReceive('writeLine')
            ->with('with message: ')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('expected configuration key "zf_locator_generator" not found')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('and trace: ');
        $console->shouldReceive('writeLine')
            ->with('/^#0/');    //mockery IS awesome: https://github.com/padraic/mockery/blob/master/docs/07-ARGUMENT-VALIDATION.md

        $serviceLocator->shouldReceive('get')
            ->once()
            ->with('Config')
            ->andReturn($configuration);

        $this->routeMatch->setParam('action', 'list');

        $this->controller->dispatch($this->request);
    }

    public function testListActionWithEmptyConfiguration()
    {
        $configuration = array(
            'zf_locator_generator' => array(
                'name_to_configuration_path' => array()
            )
        );
        $serviceLocator = $this->serviceLocator;

        $serviceLocator->shouldReceive('get')
            ->once()
            ->with('Config')
            ->andReturn($configuration);

        $this->routeMatch->setParam('action', 'list');

        $this->controller->dispatch($this->request);
    }

    public function testListActionWithFilledConfiguration()
    {
        $configuration = array(
            'zf_locator_generator' => array(
                'name_to_configuration_path' => array(
                    'locator_one' => __FILE__,
                    'locator_two' => __FILE__
                )
            )
        );
        $console = $this->console;
        $serviceLocator = $this->serviceLocator;

        $console->shouldReceive('writeLine')
            ->with('locator: locator_one with configuration file "' . __FILE__ . '"')
            ->once();
        $console->shouldReceive('writeLine')
            ->with('locator: locator_two with configuration file "' . __FILE__ . '"')
            ->once();

        $serviceLocator->shouldReceive('get')
            ->once()
            ->with('Config')
            ->andReturn($configuration);

        $this->routeMatch->setParam('action', 'list');

        $this->controller->dispatch($this->request);
    }
} 