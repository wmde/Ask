# Installation of Ask

These is the install file for the [Ask library](https://www.mediawiki.org/wiki/Extension:Ask).

## Requirements

Ask requires:

* PHP 5.3 or above
* DataValues library 0.1 or above
* If used as MediaWiki extension: MediaWiki 1.16 or later

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

You can obtain the code by doing a git clone as follows:

    git clone https://gerrit.wikimedia.org/r/p/mediawiki/extensions/Ask.git

In case you are installing Ask as MediaWiki extension, include the entry point as
follows in your LocalSettings.php file:

    # Ask
    require_once( "$IP/extensions/Ask/Ask.php" );

