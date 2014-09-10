<?php

namespace Application\Controller\Console;

use ZfConsoleHelper\Controller\Console\AbstractConsoleController;

class IndexController extends AbstractConsoleController
{
    public function indexAction()
    {
        try {
            $this->throwExceptionIfNotCalledInsideAnCliEnvironment();

            $this->attachSignalHandler($this);

            //some example items
            //  simple think about a lot of items that indicates longer
            //  processing runtime
            $items = array('one', 'two', 'three', 'four');

            //use implemented method to react on signal handling
            $this->processItems(
                $items,             //big list of items
                $this,              //current object
                'processItem',      //method that should be called for each item
                $arguments = array( //additional arguments for method 'processItem' (if needed)
                    'foo',
                    'bar'
                )
            );
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
    * @param string $item
    * @param string $stringOne
    * @param string $stringTwo
    */
    protected function processItem($item, $stringOne, $stringTwo)
    {
        $console = $this->getConsole();
        $console->writeLine(
            'this is item "' . $item .
            '" with string one "' . $stringOne . '"' .
            '" and string two "' . $stringTwo . '"'
        );
    }

    /**
    * @return boolean
    */
    private function beVerbose()
    {
        return $this->hasBooleanParameter('v', 'verbose');
    }
}
