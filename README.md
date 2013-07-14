# Ask

[![Latest Stable Version](https://poser.pugx.org/ask/ask/version.png)](https://packagist.org/packages/ask/ask)
[![Latest Stable Version](https://poser.pugx.org/ask/ask/d/total.png)](https://packagist.org/packages/ask/ask)
[![Build Status](https://secure.travis-ci.org/wikimedia/mediawiki-extensions-Ask.png?branch=master)](http://travis-ci.org/wikimedia/mediawiki-extensions-Ask)

Library containing a PHP implementation of the Ask query language

## Requirements

* PHP 5.3 or later
* [DataValues](https://www.mediawiki.org/wiki/Extension:DataValues) 0.1 or later
* [Serialization](https://github.com/wikimedia/mediawiki-extensions-Serialization/blob/master/README.md) 1.0 or later

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `ask/ask` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
Ask 1.0:

    {
        "require": {
            "ask/ask": "1.0.*"
        }
    }

### Manual

Get the Ask code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the Ask library by including its entry point:
Ask.php.

## Usage

The [extension page on mediawiki.org](https://www.mediawiki.org/wiki/Extension:Ask)
contains the documentation and examples for this library.

## Links

* [Ask on Packagist](https://packagist.org/packages/ask/ask)
* [Ask on Ohloh](https://www.ohloh.net/p/ask)
* [Ask on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:Ask)
* [TravisCI build status](https://travis-ci.org/wikimedia/mediawiki-extensions-Ask)
* [Latest version of the readme file](https://github.com/wikimedia/mediawiki-extensions-Ask/blob/master/README.md)