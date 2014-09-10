<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-02 
 */

namespace ZfLocatorGenerator\Controller\Console;

use Exception;
use InvalidArgumentException;
use RuntimeException;
use Zend\Config\Config;
use Zend\Console\ColorInterface;

/**
 * Class IndexController
 * @package LocatorGenerator\Controller\Console
 */
class IndexController extends AbstractController
{
    /**
     * @var string
     */
    private $configurationKey = 'zf_locator_generator';

    public function generateAction()
    {
        $beVerbose = $this->beVerbose();
        /** @var \Net\Bazzline\Component\Locator\Command $command */
        $command = $this->serviceLocator->get('LocatorGeneratorCommand');
        /** @var \Zend\Config\Config $configuration */
        $configuration = $this->serviceLocator->get('Config');
        $console = $this->getConsole();

        try {
            $this->throwExceptionIfConfigurationIsInvalid($configuration);

            $generatorConfiguration = $configuration[$this->configurationKey]['name_to_configuration_path'];

            if ($this->hasParameter('locator_name')) {
                $locatorName = $this->getParameter('locator_name');

                if (!isset($generatorConfiguration[$locatorName])) {
                    throw new InvalidArgumentException(
                        'invalid locator name provided'
                    );
                }

                $namesToPath = array($locatorName => $generatorConfiguration[$locatorName]);
            } else {
                $namesToPath = $generatorConfiguration;
            }

            foreach ($namesToPath as $name => $path) {
                if ($beVerbose) {
                    $console->writeLine(
                        'generating "' . $name . '" by using configuration file "' . $path . '"'
                    );
                } else {
                    $console->write('.');
                }

                $arguments = array(
                    __FILE__,
                    $path
                );
                $command->setArguments($arguments);

                try {
                    $command->execute();
                } catch (Exception $exception) {
                    $console->setColor(ColorInterface::LIGHT_RED);
                    $console->writeLine('could not generate locator for "' . $name . '"');
                    $console->writeLine('error: ' . $exception->getMessage());
                    $console->resetColor();
                }
            }
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    public function listAction()
    {
        /** @var \Zend\Config\Config $configuration */
        $configuration = $this->serviceLocator->get('Config');
        $console = $this->getConsole();

        try {
            $this->throwExceptionIfConfigurationIsInvalid($configuration);
            $generatorConfiguration = $configuration[$this->configurationKey]['name_to_configuration_path'];

            foreach ($generatorConfiguration as $name => $path) {
                $console->writeLine('locator: ' . $name . ' with configuration file "' . $path . '"');
            }
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * @return bool
     */
    protected function beVerbose()
    {
        return $this->hasBooleanParameter('v', 'verbose');
    }

    /**
     * @param array|Config $configuration
     * @throws \RuntimeException
     */
    private function throwExceptionIfConfigurationIsInvalid($configuration)
    {
        if (!isset($configuration[$this->configurationKey])) {
            throw new RuntimeException(
                'expected configuration key "' . $this->configurationKey . '" not found'
            );
        }
    }
} 