# Zend Framework 2 Console Helper Module

This module should easy up implementing console commands supporting [POSIX Signal Handling](https://en.wikipedia.org/wiki/POSIX_signal).
Furthermore, there are some simple but useful methods implemented:
* getParameter($name)
* getRequest()
* hasBooleanParameter($shortName = '', $longName = '')
* hasParameter($name)
* throwExceptionIfNotCalledInsideAnCliEnvironment()

It is based on the [skeleton zf2 module](https://github.com/zendframework/ZendSkeletonModule).
Thanks also to the [skeleton application](https://github.com/zendframework/ZendSkeletonApplication).

Since it is an abstract Controller, there are no test available.


The versioneye status is:
[![dependencies](https://www.versioneye.com/user/projects/540f69de9e16223a73000002/badge.svg?style=flat)](https://www.versioneye.com/user/projects/540f69de9e16223a73000002)

Downloads:
[![Downloads this Month](https://img.shields.io/packagist/dm/net_bazzline/zf_console_helper.svg)](https://packagist.org/packages/net_bazzline/zf_console_helper)

It is also available at [openhub.net](http://www.openhub.net/p/719029).

# Example / Usage

```php
<?php

namespace MyModule\Controller\Console;

use Exception;

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
     * must be protected since it will be called from the parent
     *
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
```

Code like above will output something like that.

```shell
this is item "one" with string one "foo"" and string two "bar"
this is item "two" with string one "foo"" and string two "bar"
this is item "three" with string one "foo"" and string two "bar"
this is item "four" with string one "foo"" and string two "bar"
```

# Install

## Manuel

    mkdir -p vendor/net_bazzline/zf_console_helper
    cd vendor/net_bazzline/zf_console_helper
    git clone https://github.com/bazzline/zf_console_helper

## With [Packagist](https://packagist.org/packages/net_bazzline/zf_console_helper)

    "net_bazzline/zf_console_helper": "dev-master"

# History

* [1.0.2](https://github.com/bazzline/zf_console_helper/tree/1.0.1) - not yet released
* [1.0.1](https://github.com/bazzline/zf_console_helper/tree/1.0.1) - released at 10.09.2014
    * added example code output
    * added apigen
    * moved to usage of "Zend\Mvc\Controller\AbstractConsoleController"
* [1.0.0](https://github.com/bazzline/zf_console_helper/tree/1.0.0) - released at 09.09.2014
    * initial release
