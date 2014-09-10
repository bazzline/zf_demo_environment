# Zend Framework 2 Module for the Locator Generator Component

This module should easy up the usage of the [locator generator component](https://github.com/bazzline/php_component_locator_generator) in the [zend framework 2](http://framework.zend.com/) in a zend framework 2 application.

It is based on the [skeleton zf2 module](https://github.com/zendframework/ZendSkeletonModule) and [phly_contact](https://github.com/weierophinney/phly_contact).
Thanks also to the [skeleton application](https://github.com/zendframework/ZendSkeletonApplication).

The build status of the current master branch is tracked by Travis CI:
[![Build Status](https://travis-ci.org/bazzline/zf_locator_generator.png?branch=master)](http://travis-ci.org/bazzline/zf_locator_generator)


The scrutinizer status are:
[![code quality](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator/) | [![code coverage](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator/) | [![build status](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator/)

The versioneye status is:
[![dependencies](https://www.versioneye.com/user/projects/540cac63ccc023c5e0000009/badge.svg?style=flat)](https://www.versioneye.com/user/projects/540cac63ccc023c5e0000009)

Downloads:
[![Downloads this Month](https://img.shields.io/packagist/dm/net_bazzline/zf_locator_generator.svg)](https://packagist.org/packages/net_bazzline/zf_locator_generator)

It is also available at [openhub.net]http://www.openhub.net/p/718964).

# Example

```shell
# generate one locator
php public/index.php locator generate <locator_name>

# generate all available locators
php public/index.php locator generate
```

# Install

## Manuel

    mkdir -p vendor/net_bazzline/zf_locator_generator
    cd vendor/net_bazzline/zf_locator_generator
    git clone https://github.com/bazzline/zf_locator_generator

## With [Packagist](https://packagist.org/packages/net_bazzline/zf_locator_generator)

    "net_bazzline/zf_locator_generator": "dev-master"

# Usage

* use zflocatorgenerator.global.php.dist as base
* copy this file into your config/autoload directory
* open this file and adapt it to your needs

# History

* [1.0.1](https://github.com/bazzline/zf_locator_generator/tree/1.0.1) - not yet released
* [1.0.0](https://github.com/bazzline/zf_locator_generator/tree/1.0.0) - released at 07.09.2014
    * initial release

