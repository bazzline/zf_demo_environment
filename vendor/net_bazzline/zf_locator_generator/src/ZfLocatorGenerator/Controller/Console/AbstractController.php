<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-02 
 */

namespace ZfLocatorGenerator\Controller\Console;

use Exception;
use RuntimeException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\ColorInterface;
use Zend\Console\Request as ConsoleRequest;

/**
 * Class AbstractController
 * @package LocatorGenerator\Controller\Console
 */
class AbstractController extends AbstractActionController
{
   /**
     * @var bool
     */
    protected $stopExecution = false;

    /**
     * for easy up request usage
     * @return \Zend\Stdlib\RequestInterface|ConsoleRequest
     */
    public function getRequest()
    {
        return parent::getRequest();
    }

    /**
     * @param $signal
     */
    public function defaultSignalHandler($signal)
    {
        $this->stopExecution = true;
    }

    /**
     * @param AbstractActionController $object
     * @param string $method
     */
    protected function attachSignalHandler(AbstractActionController $object, $method = 'defaultSignalHandler')
    {
        declare(ticks = 10);

        pcntl_signal(SIGHUP,    array($object, $method));
        pcntl_signal(SIGINT,    array($object, $method));
        pcntl_signal(SIGUSR1,   array($object, $method));
        pcntl_signal(SIGUSR2,   array($object, $method));
        pcntl_signal(SIGQUIT,   array($object, $method));
        pcntl_signal(SIGILL,    array($object, $method));
        pcntl_signal(SIGABRT,   array($object, $method));
        pcntl_signal(SIGFPE,    array($object, $method));
        pcntl_signal(SIGSEGV,   array($object, $method));
        pcntl_signal(SIGPIPE,   array($object, $method));
        pcntl_signal(SIGALRM,   array($object, $method));
        pcntl_signal(SIGCONT,   array($object, $method));
        pcntl_signal(SIGTSTP,   array($object, $method));
        pcntl_signal(SIGTTIN,   array($object, $method));
        pcntl_signal(SIGTTOU,   array($object, $method));
    }

    /**
     * @return \Zend\Console\Adapter\AdapterInterface
     * @see http://framework.zend.com/manual/2.2/en/modules/zend.console.adapter.html
     */
    protected function getConsole()
    {
        return $this->serviceLocator->get('console');
    }

    /**
     * @param $name
     * @return null|string
     */
    protected function getParameter($name)
    {
        return $this->getRequest()->getParam($name);
    }

    /**
     * @param Exception $exception
     */
    protected function handleException(Exception $exception)
    {
        $console = $this->getConsole();
        $console->setColor(ColorInterface::RED);

        $console->writeLine('');
        $console->writeLine('caught exception ' . get_class($exception));
        $console->writeLine('----------------');
        $console->writeLine('with message: ');
        $console->writeLine('');
        $console->setColor(ColorInterface::RESET);
        $console->writeLine($exception->getMessage());
        $console->setColor(ColorInterface::RED);
        $console->writeLine('----------------');
        $console->writeLine('and trace: ');
        $console->writeLine('');
        $console->setColor(ColorInterface::GRAY);
        $console->writeLine($exception->getTraceAsString());

        $console->setColor(ColorInterface::RESET);
    }

    /**
     * @param string $shortName
     * @param string $longName
     * @return bool
     */
    protected function hasBooleanParameter($shortName, $longName)
    {
        $has = ($this->hasParameter($shortName)
                || $this->hasParameter($longName));

        return $has;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function hasParameter($name)
    {
        return (!is_null($this->getParameter($name)));
    }

    /**
     * @throws RuntimeException
     */
    protected function throwExceptionIfNotCalledInsideAnCliEnvironment()
    {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest){
            throw new RuntimeException(
                'only callable inside console environment'
            );
        }
    }
} 